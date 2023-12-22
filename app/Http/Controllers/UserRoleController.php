<?php

namespace App\Http\Controllers;
use Exception;
use App\Http\Requests\UserRoleCreateRequest;
use App\Http\Requests\UserRoleUpdateRequest;
use App\Repositories\UserRoleRepository;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use App\Models\UserRole;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    use ResponseTrait;

    public $userLevelRepository;

    public function __construct(UserRoleRepository $userLevelRepository)
    {
        $this->userLevelRepository = $userLevelRepository;
    }


    /**
     * @OA\Get(
     *     path="/api/user_roles",
     *     tags={"User Role"},
     *     summary="Get all user_roles for REST API",
     *     description="Multiple status values can be provided with comma separated string",
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
            return $this->responseSuccess($this->userLevelRepository->getAll(request()->all()), 'User role fetched successfully.');
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/user_roles",
     *     tags={"User Role"},
     *     summary="Create user-role",
     *     description="Create user-role",
     *     security={{"bearer":{}}},
     *     @OA\RequestBody(
     *         description="User role objects",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *            @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="role",
     *                     description="User role title",
     *                     type="string",
     *                     example="User role title"
     *                 ),
     *                 
     *                 required={"role"}
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
    public function store(UserRoleCreateRequest $request): JsonResponse
    {
        try {
            return $this->responseSuccess($this->userLevelRepository->create($request->all()), 'User role created successfully.');
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @OA\Get(
     *     path="/api/user_roles/{id}",
     *     tags={"User Role"},
     *     summary="Get user-role detail",
     *     description="Get user-role detail",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="user-role id",
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
     *         description="User role not found"
     *     )
     * )
     */
    public function show(int $id): JsonResponse
    {
        try {
            return $this->responseSuccess($this->userLevelRepository->getById($id), 'User role fetched successfully.');
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/user_roles/{id}",
     *     tags={"User Role"},
     *     summary="Update user-role",
     *     description="Update user-role",
     *     security={{"bearer":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="user-role id",
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
     *         description="User role objects",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="id",
     *                     description="User role id",
     *                     type="integer",
     *                     example="User role id"
     *                 ),
     *                 @OA\Property(
     *                     property="role",
     *                     description="User role title",
     *                     type="string",
     *                     example="User role title"
     *                 ),
     *                 required={"role"}
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
    public function update(UserRoleUpdateRequest $request, int $id): JsonResponse
    {
        try {
            return $this->responseSuccess($this->userLevelRepository->update($id, $request->all()), 'User role updated successfully.');
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @OA\DELETE(
     *     path="/api/user_roles/{id}",
     *     tags={"User Role"},
     *     summary="Delete user-role",
     *     description="Delete user-role",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="user-role id",
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
     *         description="User role not found"
     *     )
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            return $this->responseSuccess($this->userLevelRepository->delete($id), 'User role deleted successfully.');
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), $exception->getCode());
        }
    }
}





