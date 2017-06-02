<?php

namespace App\Http\Middleware;

use App\Responses\SimpleResponse;
use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Middleware\BaseMiddleware;

class ApiRefreshToken extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        try {
            $newToken = $this->auth->setRequest($request)->parseToken()->refresh();
        } catch (TokenExpiredException $e) {
            return $this->respond('tymon.jwt.expired', 'token expired', $e->getStatusCode(), [$e]);
        } catch (JWTException $e) {
            return $this->respond('tymon.jwt.invalid', 'token invalid', $e->getStatusCode(), [$e]);
        }

        // send the refreshed token back to the client
        $response->headers->set('Authorization', 'Bearer '.$newToken);

        return $response;
    }

    protected function respond($event, $error, $status, $payload = [])
    {
        $response = $this->events->fire($event, $payload, true);

        return $response ?: response()->json(new SimpleResponse(false, $error, '', $status), $status);
    }
}
