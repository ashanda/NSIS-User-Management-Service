<?php

namespace App\Http\Controllers;

use App\Repositories\AuthRepository;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
     use ResponseTrait;

   
    public function __construct(private AuthRepository  $auth)
    {
        $this->auth = $auth;
    }
/**
     * @OA\Get(
     *     path="/api/profile",
     *     tags={"Authentication"},
     *     summary="User profile",
     *     description="User profile",
     *     operationId="show",
     *     security={{"bearer":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthennticated"
     *     )
     * )
     */
    public function show():JsonResponse
    {
        try {
            return Auth::guard()->user();

        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage());
        }
    }
  /**
     * @OA\Post(
     *     path="/api/logout",
     *     tags={"Authentication"},
     *     summary="User logout",
     *     description="User logout",
     *     operationId="logout",
     *     security={{"bearer":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     )
     * )
     */
    public function logout() :JsonResponse
    {
        try {
             Auth::guard()->user()->token()->revoke();
            Auth::guard()->user()->token()->delete();
            return $this->responseSuccess('','User logged out successfully');
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage());
        }
    }
}
