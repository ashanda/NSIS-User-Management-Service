<?php

namespace App\Repositories;

use Exception;
use App\Models\AccountPayable;
use App\Models\StudentPayment;
use App\Models\StudentDetail;
use App\Interfaces\FeesCalculationInterface;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class FeesCalculationRepository implements FeesCalculationInterface {
    public function monthlyFee()
    {
        try {
            // Start a database transaction
            DB::beginTransaction();

            $currentDate = Carbon::now();
            $dueDateThreshold = $currentDate->copy()->subMonths(3);
            $dueDate = $currentDate->copy()->addMonth();

           
 
            // Fetch eligible students with details
            $monthlyPaymentEligibleLists = $this->getMonthlyPaymentEligibleLists();

            // Process surcharges and create records
            $this->processSurcharges($monthlyPaymentEligibleLists, $dueDate, $dueDateThreshold);

            // Commit the transaction
            DB::commit();

            return "All records inserted successfully!";
        } catch (\Exception $e) {
            // An error occurred, rollback the transaction
            DB::rollBack();

            // Log the exception
            Log::error("Error: " . $e->getMessage());

            // Return an error response
            return "Error: " . $e->getMessage();
        }
    }

    private function getMonthlyPaymentEligibleLists()
    {
        return StudentDetail::where('sd_academic_status', 1)
            ->with('yearGradeClass')
            ->get();
    }

private function generateInvoiceNumber() {
    $timestamp = time();
    $invoiceNumber = $timestamp;
    return $invoiceNumber;
}

private function processSurcharges($monthlyPaymentEligibleLists, $dueDate, $dueDateThreshold) {
    $processedUsers = []; // Array to store processed users
    $mainIteration = 0;

    foreach ($monthlyPaymentEligibleLists as $monthlyPaymentEligibleList) {
        $mainIteration++;
        // Generate a new unique ID and extract substring for invoice number
        
        $invoice_number = $this->generateInvoiceNumber(). $mainIteration;

        $surchageEligibilitys = $this->getSurchageEligibilitys($monthlyPaymentEligibleList, $dueDateThreshold);
        $count = $surchageEligibilitys->count();

        foreach ($surchageEligibilitys as $surchageEligibility) {
            $userId = $surchageEligibility->student_id;

            // Check if the user has already been processed
            if (!in_array($userId, $processedUsers)) {
                $this->createSurchargeRecord($surchageEligibility, $count, $dueDate, $invoice_number);
                // Mark the user as processed
                $processedUsers[] = $userId;
                // Create monthly payment record
                 $this->createMonthlyPaymentRecord($monthlyPaymentEligibleList, $dueDate, $invoice_number);
            }
        }
    }
}


    private function getSurchageEligibilitys($monthlyPaymentEligibleList, $dueDateThreshold)
    {

        return AccountPayable::where('student_id', $monthlyPaymentEligibleList->student_id)
            ->where('eligibility', 1)
            ->where('status', 0)
            ->where('type', 'monthly')
            ->whereBetween('due_date', [$dueDateThreshold->format('Y-m-d'), '2023-12-10'])
            ->get();     
    }

    private function createSurchargeRecord($surchageEligibility, $count, $dueDate, $invoice_number)
    {
        // Define surcharge percentages based on count values
        $surchargePercentages = [
            3 => [10, 20, 30],  // 10%, 20%, 30% for count == 3
            2 => [10, 20],      // 10%, 20% for count == 2
            1 => [10],          // 10% for count == 1
            // Add more count => percentage mappings as needed
        ];

        // Default surcharge percentages if count is not found in the mappings
        $defaultSurchargePercentages = [10];

        // Determine the surcharge percentages based on count
        $currentSurchargePercentages = $surchargePercentages[$count] ?? $defaultSurchargePercentages;

        // Limit the loop to the minimum of the count and the number of specified percentages
        $loopCount = min($count, count($currentSurchargePercentages));
        
        // Loop through surcharge percentages and create individual records
        for ($i = 0; $i < $loopCount; $i++) {
            // Calculate surcharge amount
            $surchargePercentage = $currentSurchargePercentages[$i];
            $surchargeAmount = ($surchageEligibility->amount * $surchargePercentage) / 100;

            //Create surcharge record
            AccountPayable::create([
                'invoice_number' => $invoice_number,
                'student_id' => $surchageEligibility->student_id,
                'amount' => $surchargeAmount,
                'type' => 'surcharge',
                'eligibility' => 1,
                'due_date' => $dueDate,
                'status' => 0,
            ]);
        }
    }


    private function createMonthlyPaymentRecord($monthlyPaymentEligibleList, $dueDate, $invoice_number)
    {
        AccountPayable::create([
            'invoice_number' => $invoice_number,
            'student_id' => $monthlyPaymentEligibleList->student_id,
            'amount' => $monthlyPaymentEligibleList->yearGradeClass->monthly_fee,
            'type' => 'monthly',
            'eligibility' => 1,
            'due_date' => $dueDate,
            'status' => 0,
        ]);
    }




    public function user_payments($id){
        $query = AccountPayable::where('student_id',$id)->where('status',0)->get(); 
        return $query;
    }

    public function user_payment_update(array $data)
    {
        foreach ($data as $invoiceData) {
            StudentPayment::create([
                'invoiceId' => $invoiceData['invoiceId'],
                'date' => $invoiceData['date'],
                'dueDate' => $invoiceData['dueDate'],
                'outstandingBalance' => $invoiceData['outstandingBalance'],
                'total' => $invoiceData['total'],
            ]);
        }
    }
    
    public function prepareForDB(array $data, ?StudentPayment $master_class = null): array
    {
        return [
            'student_id' => $data['organization_id'],
            'due_amount' => $data['class_name'],
            'due_amount' => $data['class_name'],

        ];
    }

public function current_user_pay(array $data)
{
        $admissionId = $data['admission_id'];
        $amount = $data['amount'];
        $date = $data['date'];
        
    // Assuming you have a relationship between users and invoices, adjust this based on your actual relationship
    $invoices = AccountPayable::where('admission_no', $admissionId)
        ->where('status', 0) // Assuming 0 means unpaid
        ->where('due_date','<', $date)
        ->select('invoice_number', DB::raw('SUM(amount) as total_amount'), DB::raw('SUM(outstanding_balance) as total_outstanding_balance'), 'due_date', 'status')
        ->groupBy('invoice_number', 'due_date', 'status')
        ->get();

    // If you want to process each invoice separately
    $invoiceDataArray = [];
    foreach ($invoices as $invoice) {
        $totalAmount = $invoice->total_amount;
        $dueDate = $invoice->due_date;
        $current_date = Carbon::now()->format('Y-m-d');
        $describeData = [];
        // Assuming you have a relationship between invoices and details, adjust this based on your actual relationship
        $invoiceDetails = AccountPayable::where('invoice_number', $invoice->invoice_number)->where('status', 0)->get();

        $paidAmount = 0;
        $outstandingBalance = 0; // Initialize outstanding balance for the entire invoice

        foreach ($invoiceDetails as $index => $detail) {
            $paymentStatus = 'unpaid';
            $detailOutstandingBalance = $detail->amount;

            if ($amount >= $detailOutstandingBalance) {
                $paymentStatus = 'paid';
                $amount -= $detailOutstandingBalance;
                $detailOutstandingBalance = 0;
            } elseif ($amount > 0) {
                $paymentStatus = 'partially paid';
                $detailOutstandingBalance -= $amount;
                $amount = 0;
            }

            $describeData[] = [
                'id' => $detail->id,
                'type' => $detail->type,
                'amount' => $detail->amount,
                'payment_status' => $paymentStatus,
                'outstanding_balance' => $detailOutstandingBalance, // Represent the outstanding balance as a negative value for partially paid charges
                'created_at' => $detail->created_at,
                'updated_at' => $detail->updated_at,
            ];

            // Calculate the paid amount for each detail
            $paidAmount += $detail->amount;
            // Aggregate the outstanding balance for the entire invoice
            $outstandingBalance += $detailOutstandingBalance;
        }

        // Check if there are any unpaid or partially paid charges
        $hasUnpaidCharge = false;
        $hasPartiallyPaidCharge = false;

        foreach ($describeData as $charge) {
            if ($charge['payment_status'] === 'unpaid') {
                $hasUnpaidCharge = true;
            } elseif ($charge['payment_status'] === 'partially paid') {
                $hasPartiallyPaidCharge = true;
            }
        }

        // Set the invoice status based on the payment status of charges
        if ($hasPartiallyPaidCharge) {
            $invoiceStatus = 'partially paid';
        } elseif ($hasUnpaidCharge) {
            $invoiceStatus = 'unpaid';
        } else {
            $invoiceStatus = 'paid';
        }

        // Calculate the outstanding balance for the entire invoice
        $outstandingBalance = ($outstandingBalance < 0) ? 0 : $outstandingBalance;

        $invoiceDataArray[] = [
            'invoice_id' => $invoice->invoice_number,
            'total' => $totalAmount,
            'due_date' => $dueDate,
            'describe' => $describeData,
            'invoice_status' => $invoiceStatus,
            'outstanding_balance' => -$outstandingBalance, // Represent the outstanding balance as a negative value for the entire invoice
            'current_date' => $current_date,
        ];
    }

    $responseData = [
        'invoice_data' => $invoiceDataArray,
    ];

    return $responseData;
}

    public function all_user_pay(array $data){
        echo  'mac';
    }




}


