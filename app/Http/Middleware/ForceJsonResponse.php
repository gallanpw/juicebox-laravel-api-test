<?php

// namespace App\Http\Middleware;

// use Closure;
// use Symfony\Component\HttpFoundation\Response;
// use Illuminate\Http\Request;
// use Illuminate\Auth\AuthenticationException;
// use Illuminate\Support\Facades\Auth;

// class ForceJsonResponse
// {
//     /**
//      * Handle an incoming request.
//      *
//      * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
//      */
//     public function handle(Request $request, Closure $next): Response
//     {
//         // Pastikan hanya request API yang dipaksa JSON
//         if ($request->is('api/*')) {
//             $request->headers->set('Accept', 'application/json');
//         }

//         return $next($request);
//     }
// }
