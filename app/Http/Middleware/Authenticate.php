<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponse;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Symfony\Component\HttpFoundation\Response;

class Authenticate extends Middleware
{
    use ApiResponse;

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $user = $request->user('api');

        if ($user) {
            $request->merge(['user' => $user]);

            return $next($request);
        }

        return $this->errorResponse(
            null,
            Response::HTTP_UNAUTHORIZED,
            'Вы не авторизованы'
        );
    }
}
