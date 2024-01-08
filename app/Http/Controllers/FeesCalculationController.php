<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Repositories\FeesCalculationRepository;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class FeesCalculationController extends Controller
{
    use ResponseTrait;

    public $feescalculationRepository;

    public function __construct(FeesCalculationRepository $feescalculationRepository)
    {
        $this->feescalculationRepository = $feescalculationRepository;
    }

    public function monthly_fee(): JsonResponse
    {
        try {
            return $this->responseSuccess($this->feescalculationRepository->monthlyFee(), 'Monthly fee generate successfully.');
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), $exception->getCode());
        }
    }

    public function surcharge_fee(): JsonResponse
    {
        try {
            return $this->responseSuccess($this->feescalculationRepository->surchargeFee(), 'Surcharged fee generate successfully.');
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), $exception->getCode());
        }
    }

    public function user_payments($id): JsonResponse
    {
        try {
            return $this->responseSuccess($this->feescalculationRepository->user_payments($id), 'User payments fetch successfully.');
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), $exception->getCode());
        }
    }
}
