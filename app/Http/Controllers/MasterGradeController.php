<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Http\Requests\MasterGradeCreateRequest;
use App\Http\Requests\MasterGradeUpdateRequest;
use App\Repositories\MasterGradeRepository;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class MasterGradeController extends Controller
{
    use ResponseTrait;

    public $mastergradeRepository;

    public function __construct(MasterGradeRepository $mastergradeRepository)
    {
        $this->mastergradeRepository = $mastergradeRepository;
    }


    public function index(): JsonResponse
    {
        try {
            return $this->responseSuccess($this->mastergradeRepository->getAll(request()->all()), 'Master grade fetched successfully.');
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), $exception->getCode());
        }
    }


    public function store(MasterGradeCreateRequest $request): JsonResponse
    {
        try {
            return $this->responseSuccess($this->mastergradeRepository->create($request->all()), 'Master grade created successfully.');
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), $exception->getCode());
        }
    }


    public function show(int $id): JsonResponse
    {
        try {
            return $this->responseSuccess($this->mastergradeRepository->getById($id), 'Master grade fetched successfully.');
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), $exception->getCode());
        }
    }


     public function update(MasterGradeUpdateRequest $request, int $id): JsonResponse
    {
        try {
            return $this->responseSuccess($this->mastergradeRepository->update($id, $request->all()), 'Master grade updated successfully.');
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), $exception->getCode());
        }
    }


      public function destroy(int $id): JsonResponse
    {
        try {
            return $this->responseSuccess($this->mastergradeRepository->delete($id), 'Master grade deleted successfully.');
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), $exception->getCode());
        }
    }
}
