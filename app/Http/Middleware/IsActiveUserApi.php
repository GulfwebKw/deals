<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class IsActiveUserApi
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
        if (Auth::guard("api_freelancer")->check()) {
            $freelancer = Auth::guard("api_freelancer")->user();
            if (!$freelancer->is_active) {
                // $freelancer->pushNotification()->delete();
                // $freelancer->AauthAcessToken()->delete();
                return response()->json([
                    'status' => 401,
                    'data' => [],
                    'message' => ['Account is inactive!']
                ], 401);
            }
            if ($freelancer->is_approved != "approved") {
                return response()->json([
                    'status' => 401,
                    'data' => [],
                    'message' => [trans('api.freelancer.' . ( $freelancer->is_approved == "pending" ? "pending" : "reject") )]
                ], 401);
            }
        }
        if (Auth::guard('user')->check()) {
            $user = Auth::guard('user')->user();
            if (!$user->is_active) {
                $user->pushNotification()->delete();
                $user->AauthAcessToken()->delete();
                return response()->json([
                    'status' => 401,
                    'data' => [],
                    'message' => ['You Are Deactivated!']
                ], 401);
            }
        }
        return $next($request);
    }
}
