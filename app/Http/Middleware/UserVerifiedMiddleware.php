<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Traits\GetResponseJson;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserVerifiedMiddleware
{
    use GetResponseJson;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user =User::where('email',$request->email)->first();

        if(!$user || !$user->email_verified_at){
            return $this->setErrorMessage('User Not Verified');
        }

        return $next($request);
    }
}
