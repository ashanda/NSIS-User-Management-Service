<?php

namespace App\Http\Controllers;
use Exception;
use App\Http\Requests\UserActivityCreateRequest;
use App\Http\Requests\UserActivityUpdateRequest;
use App\Repositories\UserActivityRepository;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use App\Models\UserActivity;
use Illuminate\Http\Request;

class UserActivityController extends Controller
{
    use ResponseTrait;

    public $userActivityRepository;

    public function __construct(UserActivityRepository $userActivityRepository)
    {
        $this->userActivityRepository = $userActivityRepository;
    }


    /**
     * @OA\Get(
     *     path="/api/user_activities",
     *     tags={"User Activity"},
     *     summary="Get all user activities",
     *     description="Retrieve a list of user activities",

     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/UserActivity"))
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        try {
            return $this->responseSuccess($this->userActivityRepository->getAll(request()->all()), 'User Activity fetched successfully.');
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/user_activities",
     *     tags={"User Activity"},
     *     summary="Create user activity",
     *     description="Create user activity",
     *     security={{"bearer":{}}},
     *     @OA\RequestBody(
     *         description="User Activity objects",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *            @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="activity",
     *                     description="User Activity",
     *                     type="string",
     *                     example="User Activity"
     *                 ),
     *                 required={"activity"}
     *             )
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function store(UserActivityCreateRequest $request): JsonResponse
    {
        try {
            return $this->responseSuccess($this->userActivityRepository->create($request->all()), 'User Activity created successfully.');
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @OA\Get(
     *     path="/api/user_activities/{id}",
     *     tags={"User Activity"},
     *     summary="Get user-activity detail",
     *     description="Get user-activity detail",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="user-activity id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     security={{"bearer":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User Activity not found"
     *     )
     * )
     */
    public function show(int $id): JsonResponse
    {
        try {
            return $this->responseSuccess($this->userActivityRepository->getById($id), 'User Activity fetched successfully.');
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/user_activities/{id}",
     *     tags={"User Activity"},
     *     summary="Update user-activity",
     *     description="Update user-activity",
     *     security={{"bearer":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="user-activity id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="_method",
     *         in="query",
     *         description="request method",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="PUT"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="User Activity objects",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="id",
     *                     description="User Activity id",
     *                     type="integer",
     *                     example="User Activity id"
     *                 ),
     *             )
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function update(UserActivityUpdateRequest $request, int $id): JsonResponse
    {
        try {
            return $this->responseSuccess($this->userActivityRepository->update($id, $request->all()), 'User Activity updated successfully.');
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @OA\DELETE(
     *     path="/api/user_activities/{id}",
     *     tags={"User Activity"},
     *     summary="Delete user-activity",
     *     description="Delete user-activity",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="user-activity id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     security={{"bearer":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User Activity not found"
     *     )
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            return $this->responseSuccess($this->userActivityRepository->delete($id), 'User Activity deleted successfully.');
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), $exception->getCode());
        }
    }
}

