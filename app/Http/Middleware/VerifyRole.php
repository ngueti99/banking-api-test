<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $role = auth()->user()->role;

        if (!$role =='employer') {
            $data = [
                'status' => 'error',
                'message'=>'not authorized'
            ];
            return response($data,401);
        }
        return $next($request);
    }
}
