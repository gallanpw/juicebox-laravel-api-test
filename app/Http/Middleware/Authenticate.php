<?php

// namespace App\Http\Middleware;

// use Closure;
// use Symfony\Component\HttpFoundation\Response;
// use Illuminate\Http\Request;
// use Illuminate\Auth\Middleware\Authenticate as Middleware;
// use Illuminate\Auth\AuthenticationException;
// use Illuminate\Support\Facades\Auth;

// class Authenticate
// {
//     /**
//      * Handle an incoming request.
//      *
//      * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
//      */
//     public function handle(Request $request, Closure $next): Response
//     {
//         if (!$request->user()) {
//             return response()->json(['message' => 'Unauthorized'], 401);
//         }

//         return $next($request);
//     }

//     /**
//      * Handle an unauthenticated user.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @param  \Illuminate\Auth\AuthenticationException  $exception
//      */
//     protected function unauthenticated($request, AuthenticationException $exception)
//     {
//         return response()->json(['message' => 'Unauthorized'], 401);
//     }
    
// }
