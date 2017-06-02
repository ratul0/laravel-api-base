<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Responses\ApiResponse;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


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
        $response = $this->authService->login($request);
        return $response;
    }

    public function refreshToken()
    {
        return $this->authService->getRefreshToken();
    }
}
