<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $credentials = [
            'email'    => $request->input('email'),
            'password' => $request->input('password'),
        ];

        $user = \Sentinel::authenticate($credentials);
        $data =\Sentinel::check('email');
        if(empty($data)) 
        {
           return redirect('/');
        } 

        return $next($request);
    }
}
