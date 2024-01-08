<?php

namespace App\Interfaces;

use Illuminate\Contracts\Pagination\Paginator;

interface FeesCalculationInterface {
    public function monthlyFee();
    public function surchargeFee();
    public function user_payments($id);

}