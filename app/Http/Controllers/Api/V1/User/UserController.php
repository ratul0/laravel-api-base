<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Requests\User\UserRequest;
use App\Responses\ApiResponse;
use App\Services\UserService;
use App\Transformers\Api\UserTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * @var ApiResponse
     */
    private $apiResponse;
    /**
     * @var UserService
     */
    private $userService;

    /**
     * UserController constructor.
     * @param ApiResponse $apiResponse
     * @param UserService $userService
     */
    public function __construct(ApiResponse $apiResponse,UserService $userService)
    {
        $this->apiResponse = $apiResponse;
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->getFilterWithPaginatedData([]);
        return $this->apiResponse->paginatedCollection($users,new UserTransformer());
    }

    public function store(UserRequest $request)
    {
        $user = $this->userService->create($request->only(['name','email','password']));
        if($user){
            return $this->apiResponse->item($user,new UserTransformer());
        }

        return $this->apiResponse->error('something went wrong.');
    }
}
