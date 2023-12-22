<?php

namespace App\Http\Controllers;
use Exception;
use App\Http\Requests\UserAssigneeCreateRequest;
use App\Http\Requests\UserAssigneeUpdateRequest;
use App\Repositories\UserAssigneeRepository;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use App\Models\UserAssigning;
use Illuminate\Http\Request;

class UserAssigningController extends Controller
{
    use ResponseTrait;

    public $userAssigneeRepository;

    public function __construct(UserAssigneeRepository $userAssigneeRepository)
    {
        $this->userAssigneeRepository = $userAssigneeRepository;
    }


    /**
     * @OA\Get(
     *     path="/api/user_assignees",
     *     tags={"User Permission"},
     *     summary="Get all user_assignees for REST API",
     *     description="Multiple status values can be provided with comma separated string",
     *     @OA\Parameter(
     *         name="perPage",
     *         in="query",
     *         description="Per page count",
     *         required=false,
     *         explode=true,
     *         @OA\Schema(
     *             default="10",
     *             type="integer",
     *         )
     *     ),
     *     security={{"bearer":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid status value"
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        try {
            return $this->responseSuccess($this->userAssigneeRepository->getAll(request()->all()), 'User Assign Permission fetched successfully.');
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/user_assignees",
     *     tags={"User Permission"},
     *     summary="Create user-permission",
     *     description="Create user-permission",
     *     security={{"bearer":{}}},
     *     @OA\RequestBody(
     *         description="User Assign Permission objects",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *            @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="user_id",
     *                     description="User Assign User ID",
     *                     type="string",
     *                     example="1"
     *                 ),
     *                 @OA\Property(
     *                     property="level_id",
     *                     description="User Assign level ID",
     *                     type="string",
     *                     example="1"
     *                 ),
     *                 @OA\Property(
     *                     property="role_id",
     *                     description="User Assign Permission Role ID",
     *                     type="integer",
     *                     example="1"
     *                 ),
     *                 @OA\Property(
     *                     property="activity_ids",
     *                     description="User Assign Permission Activity",
     *                     type="string",
     *                 ),
     *                 required={"user_id","level_id", "role_id","activity_ids"}
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
    public function store(UserAssigneeCreateRequest $request): JsonResponse
    {
        try {
            return $this->responseSuccess($this->userAssigneeRepository->create($request->all()), 'User Assign Permission created successfully.');
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @OA\Get(
     *     path="/api/user_assignees/{id}",
     *     tags={"User Permission"},
     *     summary="Get user-permission detail",
     *     description="Get user-permission detail",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="user-permission id",
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
     *         description="User Assign Permission not found"
     *     )
     * )
     */
    public function show(int $id): JsonResponse
    {
        try {
            return $this->responseSuccess($this->userAssigneeRepository->getById($id), 'User Assign Permission fetched successfully.');
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/user_assignees/{id}",
     *     tags={"User Permission"},
     *     summary="Update user-permission",
     *     description="Update user-permission",
     *     security={{"bearer":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="user-permission id",
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
     *         description="User Assign Permission objects",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *            @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="user_id",
     *                     description="User Assign User ID",
     *                     type="string",
     *                     example="1"
     *                 ),
     *                 @OA\Property(
     *                     property="level_id",
     *                     description="User Assign level ID",
     *                     type="string",
     *                     example="1"
     *                 ),
     *                 @OA\Property(
     *                     property="role_id",
     *                     description="User Assign Permission Role ID",
     *                     type="integer",
     *                     example="1"
     *                 ),
     *                 @OA\Property(
     *                     property="activity_ids",
     *                     description="User Assign Permission Activity",
     *                     type="string",
     *                 ),
     *                 required={"user_id","level_id", "role_id","activity_ids"}
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
    public function update(UserAssigneeUpdateRequest $request, int $id): JsonResponse
    {
        try {
            return $this->responseSuccess($this->userAssigneeRepository->update($id, $request->all()), 'User Assign Permission updated successfully.');
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @OA\DELETE(
     *     path="/api/user_assignees/{id}",
     *     tags={"User Permission"},
     *     summary="Delete user-permission",
     *     description="Delete user-permission",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="user-permission id",
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
     *         description="User Assign Permission not found"
     *     )
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            return $this->responseSuccess($this->userAssigneeRepository->delete($id), 'User Assign Permission deleted successfully.');
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), $exception->getCode());
        }
    }
}

