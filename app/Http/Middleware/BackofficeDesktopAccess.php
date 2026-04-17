<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BackofficeDesktopAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->isMobile($request)) {
            abort(403, 'Cette fonctionnalité n’est pas disponible sur mobile.');
        }

        return $next($request);
    }

    private function isMobile(Request $request): bool
    {
        $userAgent = $request->userAgent() ?? '';

        return preg_match(
            '/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i',
            $userAgent
        );
    }
}
