<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AddCacheHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Only apply caching headers to successful responses
        if ($response->getStatusCode() == 200) {
            // Static assets - long cache
            if ($this->isStaticAsset($request)) {
                $response->headers->set('Cache-Control', 'public, max-age=31536000'); // 1 year
                $response->headers->set('Expires', gmdate('D, d M Y H:i:s \G\M\T', time() + 31536000));
            }
            // API responses - short cache
            elseif ($request->is('api/*')) {
                $response->headers->set('Cache-Control', 'public, max-age=300'); // 5 minutes
            }
            // Regular pages - medium cache
            else {
                $response->headers->set('Cache-Control', 'public, max-age=1800'); // 30 minutes
                $response->headers->set('Expires', gmdate('D, d M Y H:i:s \G\M\T', time() + 1800));
            }

            // Add ETag for better caching
            if (!$response->headers->has('ETag')) {
                $response->setEtag(md5($response->getContent()));
            }

            // Compress content
            if (!$response->headers->has('Content-Encoding')) {
                $response->headers->set('Vary', 'Accept-Encoding');
            }
        }

        return $response;
    }

    /**
     * Check if the request is for a static asset
     */
    private function isStaticAsset(Request $request): bool
    {
        $path = $request->getPathInfo();
        $extensions = ['.css', '.js', '.png', '.jpg', '.jpeg', '.gif', '.webp', '.svg', '.ico', '.woff', '.woff2', '.ttf'];
        
        foreach ($extensions as $ext) {
            if (str_ends_with($path, $ext)) {
                return true;
            }
        }
        
        return false;
    }
}
