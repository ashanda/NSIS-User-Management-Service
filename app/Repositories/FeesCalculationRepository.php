<?php

namespace App\Repositories;

use Exception;
use App\Models\AccountPayable;
use App\Models\StudentPayment;
use App\Models\StudentDetail;
use App\Interfaces\FeesCalculationInterface;
use Illuminate\Support\Facades\DB;


class FeesCalculationRepository implements FeesCalculationInterface {
    public function monthlyFee()
    {
        try {
                // Start a database transaction
                DB::beginTransaction();

                // Perform the join query
                $monthlyPaymentEligibleLists = StudentDetail::where('sd_academic_status', 1)
                ->with('yearGradeClass')
                ->get();
                
                // Loop through the result set and attempt to create records using the Payment model
                foreach ($monthlyPaymentEligibleLists as $monthlyPaymentEligibleList) {

                    AccountPayable::create([
                        'student_id' => $monthlyPaymentEligibleList->student_id,
                        'amount' => $monthlyPaymentEligibleList->yearGradeClass->monthly_fee,
                        'type' => 'monthly',
                        'eligibility' => 1,
                        'status' => 0,
                    ]);
                }

                    // Commit the transaction
                    DB::commit();

                    // All records were inserted successfully
                    return "All records inserted successfully!";
        } catch (\Exception $e) {
                // An error occurred, rollback the transaction
                DB::rollBack();

                // Handle the exception (log it, return an error response, etc.)
                return "Error: " . $e->getMessage();
            }

    }

    public function surchargeFee()
    {

    }

    public function user_payments($id){
        $query = AccountPayable::where('student_id',$id)->where('status',0)->get(); 
        return $query;
    }

    
    




}