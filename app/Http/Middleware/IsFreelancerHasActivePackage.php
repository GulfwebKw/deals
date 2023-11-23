<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class IsFreelancerHasActivePackage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard("api_freelancer")->check()){
            $freelancer = Auth::guard("api_freelancer")->user();
            if (  Carbon::now()->lt($freelancer->expiration_date) )
                return $next($request);
            $freelancer->pushNotification()->delete();
            $freelancer->AauthAcessToken()->delete();
            return response()->json([
                'status' => 401,
                'data' => [],
                'message' => [trans('api.PackageExpired')]
            ], 401);
        }
        return response()->json([
            'status' => 401,
            'data' => [],
            'message' => ['Unauthenticated.']
        ], 401);
    }
}
