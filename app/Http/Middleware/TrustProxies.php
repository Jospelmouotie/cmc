<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class TrustProxies
{
    /**
     * The trusted proxies for this application.
     *
     * @var array
     */
    protected $proxies;

    /**
     * The headers that should be used to detect proxies.
     *
     * @var int
     */
    protected $headers = SymfonyRequest::HEADER_X_FORWARDED_FOR |
        SymfonyRequest::HEADER_X_FORWARDED_HOST |
        SymfonyRequest::HEADER_X_FORWARDED_PORT |
        SymfonyRequest::HEADER_X_FORWARDED_PROTO |
        SymfonyRequest::HEADER_X_FORWARDED_AWS_ELB;

    public function handle(Request $request, Closure $next)
    {
        $request->setTrustedProxies($this->proxies ?: $request->getClientIps(), $this->headers);

        return $next($request);
    }
}
