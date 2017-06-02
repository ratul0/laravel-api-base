<?php

namespace App\Traits;

use App\Responses\SimpleResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

trait RestExceptionHandlerTrait
{

    /**
     * Creates a new JSON response based on exception type.
     *
     * @param Request $request
     * @param Exception $e
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getJsonResponseForException(Request $request, Exception $e)
    {
        switch(true) {
            case $this->isModelNotFoundException($e):
                $returnValue = $this->modelNotFound();
                break;
            case $this->isTokenExpiredException($e):
                $returnValue = $this->tokenExpired();
                break;
            case $this->isTokenExpiredException($e):
                $returnValue = $this->tokenExpired();
                break;
            default:
                $returnValue = $this->badRequest();
        }

        return $returnValue;
    }

    /**
     * Returns json response for generic bad request.
     *
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function badRequest($message='Bad request', $statusCode=400)
    {
        return response()->json(
            new SimpleResponse(false, $message, '', $statusCode),
            $statusCode
        );
    }

    /**
     * Returns json response for Eloquent model not found exception.
     *
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function modelNotFound($message='Record not found', $statusCode=404)
    {
        return response()->json(
            new SimpleResponse(false, $message, '', $statusCode),
            $statusCode
        );
    }

    /**
     * Returns json response for Eloquent model not found exception.
     *
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function tokenExpired($message='Token Expired', $statusCode=401)
    {
        return response()->json(
            new SimpleResponse(false, $message, '', $statusCode),
            $statusCode
        );
    }

    /**
     * Returns json response.
     *
     * @param array|null $payload
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonResponse(array $payload=null, $statusCode=404)
    {
        $payload = $payload ?: [];

        return response()->json($payload, $statusCode);
    }

    /**
     * Determines if the given exception is an Eloquent model not found.
     *
     * @param Exception $e
     * @return bool
     */
    protected function isModelNotFoundException(Exception $e)
    {
        return $e instanceof ModelNotFoundException;
    }

    /**
     * Determines if the given exception is an Token Expired Exception.
     *
     * @param Exception $e
     * @return bool
     */
    protected function isTokenExpiredException(Exception $e)
    {
        return $e instanceof TokenExpiredException;
    }

}