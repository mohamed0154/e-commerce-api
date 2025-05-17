<?php

namespace App\Http\Middleware;

use App\Traits\GetResponseJson;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserRoleMiddleware
{
    use GetResponseJson;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

         if(!$request->user()->tokenCan('role:user')){
            return $this->setErrorMessage('UnAuthorized');
        }
        return $next($request);
    }
}
