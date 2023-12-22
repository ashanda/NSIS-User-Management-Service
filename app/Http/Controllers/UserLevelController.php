<?php

namespace App\Http\Controllers;
use Exception;
use App\Http\Requests\UserLevelCreateRequest;
use App\Http\Requests\UserLevelUpdateRequest;
use App\Repositories\UserLevelRepository;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use App\Models\UserLevel;
use Illuminate\Http\Request;

class UserLevelController extends Controller
{
    use ResponseTrait;

    public $userLevelRepository;

    public function __construct(UserLevelRepository $userLevelRepository)
    {
        $this->userLevelRepository = $userLevelRepository;
    }


    /**
     * @OA\Get(
     *     path="/api/user_levels",
     *     tags={"User Level"},
     *     summary="Get all user_levels for REST API",
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
            return $this->responseSuccess($this->userLevelRepository->getAll(request()->all()), 'User Level fetched successfully.');
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/user_levels",
     *     tags={"User Level"},
     *     summary="Create user-level",
     *     description="Create user-level",
     *     security={{"bearer":{}}},
     *     @OA\RequestBody(
     *         description="User Level objects",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *            @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="level",
     *                     description="User Level",
     *                     type="string",
     *                     example="1"
     *                 ),
     *                 @OA\Property(
     *                     property="title",
     *                     description="User Level Title",
     *                     type="string",
     *                     example="high"
     *                 ),
     *                
     *                 required={"level", "title"}
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
    public function store(UserLevelCreateRequest $request): JsonResponse
    {
        try {
            return $this->responseSuccess($this->userLevelRepository->create($request->all()), 'User Level created successfully.');
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @OA\Get(
     *     path="/api/user_levels/{id}",
     *     tags={"User Level"},
     *     summary="Get user-level detail",
     *     description="Get user-level detail",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="user-level id",
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
     *         description="User Level not found"
     *     )
     * )
     */
    public function show(int $id): JsonResponse
    {
        try {
            return $this->responseSuccess($this->userLevelRepository->getById($id), 'User Level fetched successfully.');
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/user_levels/{id}",
     *     tags={"User Level"},
     *     summary="Update user-level",
     *     description="Update user-level",
     *     security={{"bearer":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="user-level id",
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
     *         description="User Level objects",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="id",
     *                     description="User Level id",
     *                     type="integer",
     *                     example="User Level id"
     *                 ),
     *                 @OA\Property(
     *                     property="level",
     *                     description="User Level",
     *                     type="string",
     *                     example="1"
     *                 ),
     *                 @OA\Property(
     *                     property="title",
     *                     description="User Level Title",
     *                     type="string",
     *                     example="high"
     *                 ),
     *                
     *                 required={"level", "title"}
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
    public function update(UserLevelUpdateRequest $request, int $id): JsonResponse
    {
        try {
            return $this->responseSuccess($this->userLevelRepository->update($id, $request->all()), 'User Level updated successfully.');
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @OA\DELETE(
     *     path="/api/user_levels/{id}",
     *     tags={"User Level"},
     *     summary="Delete user-level",
     *     description="Delete user-level",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="user-level id",
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
     *         description="User Level not found"
     *     )
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            return $this->responseSuccess($this->userLevelRepository->delete($id), 'User Level deleted successfully.');
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), $exception->getCode());
        }
    }
}





