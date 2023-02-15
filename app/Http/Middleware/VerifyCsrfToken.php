<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;
use Closure;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/knet-response'
        //'/gwc/logout','/gwc/login'
    ];
	
	public function handle($request, Closure $next)
	{
		if ($request->is('gwc/*'))
		{
			return $next($request);
		}
	 
		return parent::handle($request, $next);
	}
}
