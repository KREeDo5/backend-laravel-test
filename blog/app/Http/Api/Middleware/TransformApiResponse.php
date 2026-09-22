<?php

namespace App\Http\Api\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TransformApiResponse
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! str_contains((string) $response->headers->get('Content-Type'), 'application/json')) {
            return $response;
        }

        $content = json_decode($response->getContent(), true);

        $success = $response->isSuccessful();
        $error = '';

        if (! $success) {
            $error = $content['message'] ?? '';
            $content = [];
        }

        $wrapped = [
            'meta' => [
                'success' => $success,
                'message' => $success ? '' : $error,
            ],
            'data' => $content ?: (object) [],
        ];

        $response->setContent(json_encode($wrapped));

        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Content-Length', (string) strlen($response->getContent()));

        return $response;
    }
}