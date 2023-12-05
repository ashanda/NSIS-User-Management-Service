<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Repositories\AuthRepository;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    use ResponseTrait;

   
    public function __construct(private AuthRepository  $auth)
    {
        $this->auth = $auth;
    }
    /**
     * @OA\POST(
     *     path="/api/register",
     *     tags={"Permissions"},
     *     summary="Register",
     *     description="Register to system.",
     *     operationId="register",
     *     security={{"bearer":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *            @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="name",
     *                     description="User Name",
     *                     type="string",
     *                     example="Jhon Doe"
     *                 ),
     *                  @OA\Property(
     *                     property="user_type",
     *                     description="User Type",
     *                     type="string",
     *                     example="0"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     description="User Email",
     *                     type="string",
     *                     example="jhon@example.com"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     description="User password",
     *                     type="string",
     *                     example="12345678"
     *                 ),
     *                 @OA\Property(
     *                     property="password_confirmation",
     *                     description="User confirm password",
     *                     type="string",
     *                     example="12345678"
     *                 ),
     *                 @OA\Property(
     *                     property="client_secret",
     *                     description="Client Secret",
     *                     type="string",
     *                     example="ZnFeVUJL3vJNz@QR9D#8NKgkbUqbFam45pc$d4Qh"
     *                 ),
     *                 required={"name", "email", "password", "password_confirmation"}
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
    public function register(RegisterRequest $request):JsonResponse
    {
        try {
            $data = $this->auth->register($request->all());
            return $this->responseSuccess($data, 'User registered successfully.');
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage());
        }
    }
}
