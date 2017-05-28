<?php

namespace App\Http\Traits;

use App\Responses\SimpleResponse;
use Illuminate\Support\Facades\App;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

trait OauthHelperTrait {
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getResourceOwner()
    {
        if(!App::runningInConsole()){
            try {

                if (! $user = JWTAuth::parseToken()->authenticate()) {
                    return response()->json(
                        new SimpleResponse(false, "user_not_found", '', 400),
                        400
                    );
                }

            } catch (TokenExpiredException $e) {

                return response()->json(
                    new SimpleResponse(false, "token_expired", '', 400),
                    400
                );

            } catch (TokenInvalidException $e) {

                return response()->json(
                    new SimpleResponse(false, "token_invalid", '', 400),
                    400
                );

            } catch (JWTException $e) {
                return response()->json(
                    new SimpleResponse(false, "token_absent", '', 400),
                    400
                );

            }

            // the token is valid and we have found the user via the sub claim
            return $user;
        }

    }

}