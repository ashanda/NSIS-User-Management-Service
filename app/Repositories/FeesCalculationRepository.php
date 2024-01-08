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
                $monthlyPaymentEligibleLists = StudentDetail::join('year_grade_classes', 'student_details.sd_year_grade_class_id', '=', 'year_grade_classes.id')
                    ->where('student_details.sd_academic_status', '=', 1)
                    ->select('student_details.*', 'year_grade_classes.*')
                    ->get();

                // Loop through the result set and attempt to create records using the Payment model
                foreach ($monthlyPaymentEligibleLists as $monthlyPaymentEligibleList) {
                    AccountPayable::create([
                        'student_id' => $monthlyPaymentEligibleList->sd_student_id,
                        'amount' => $monthlyPaymentEligibleList->monthly_fee,
                        'type' => 'monthly',
                        'eligibility' => 1,
                        'status' => 0,
                    ]);
                }

                    // Commit the transaction
                    DB::commit();

                    // All records were inserted successfully
                    echo "All records inserted successfully!";
        } catch (\Exception $e) {
                // An error occurred, rollback the transaction
                DB::rollBack();

                // Handle the exception (log it, return an error response, etc.)
                echo "Error: " . $e->getMessage();
            }

    }

    public function surchargeFee()
    {

    }

    
    




}