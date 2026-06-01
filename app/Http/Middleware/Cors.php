<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Cors
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! (bool) config('cors.enabled', true)) {
            return $next($request);
        }

        $origin = (string) $request->headers->get('Origin', '');

        $allowedOrigins = config('cors.allowed_origins', ['*']);
        $supportsCredentials = (bool) config('cors.supports_credentials', false);

        $allowAll = in_array('*', $allowedOrigins, true);
        $originAllowed = $allowAll || ($origin !== '' && in_array($origin, $allowedOrigins, true));

        if ($originAllowed) {
            $response = $next($request);

            $allowedMethods = config('cors.allowed_methods', ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS']);
            $allowedHeaders = config('cors.allowed_headers', ['Content-Type', 'Authorization', 'X-Requested-With', 'Accept', 'Origin']);
            $exposedHeaders = config('cors.exposed_headers', []);

            $response->headers->set('Access-Control-Allow-Origin', $allowAll ? '*' : $origin);
            $response->headers->set('Vary', 'Origin');

            if ($supportsCredentials) {
                $response->headers->set('Access-Control-Allow-Credentials', 'true');
            }

            $response->headers->set('Access-Control-Allow-Methods', implode(',', $allowedMethods));
            $response->headers->set('Access-Control-Allow-Headers', implode(',', $allowedHeaders));

            if (! empty($exposedHeaders)) {
                $response->headers->set('Access-Control-Expose-Headers', implode(',', $exposedHeaders));
            }

            $maxAge = (int) config('cors.max_age', 0);
            if ($maxAge > 0) {
                $response->headers->set('Access-Control-Max-Age', (string) $maxAge);
            }

            return $response;
        }

        if ($request->getMethod() === 'OPTIONS') {
            return response('', 204);
        }

        return $next($request);
    }
}
