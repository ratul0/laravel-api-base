<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Responses\ApiResponse;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * @var ApiResponse
     */
    private $apiResponse;
    /**
     * @var AuthService
     */
    private $authService;

    /**
     * AuthController constructor.
     * @param ApiResponse $apiResponse
     * @param AuthService $authService
     */
    public function __construct(ApiResponse $apiResponse,AuthService $authService)
    {

        $this->apiResponse = $apiResponse;
        $this->authService = $authService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {

        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return $this->apiResponse->error("invalid credentials");
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return $this->apiResponse->error("could not create token");
        }

        return $this->apiResponse->success($token);
    }

    public function refreshToken()
    {

        try {
            $token = JWTAuth::refresh(JWTAuth::getToken());
            return $this->apiResponse->success($token);
        } catch (\Exception $e) {
            return $this->apiResponse->error("invalid token");
        }

    }
}
