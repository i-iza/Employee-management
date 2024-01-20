<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\DepartmentController;

class IsAdmin
{
    /**
     * Handle an incoming request to check if user is administrator.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->user()->is_admin == 1){
            return $next($request);
        }else{
            return redirect('home')->with('error', 'You do not have administrator access.');
        }
    }
}
