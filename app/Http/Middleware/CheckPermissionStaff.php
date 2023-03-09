<?php

namespace App\Http\Middleware;

use App\Models\Staff;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckPermissionStaff
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next,$permission = null)
    {
        try {
            $user = Auth::guard('admin')->user();
            if($user->role){
                if($user->role == Staff::ROLE_ADMIN || $user->role == $permission || $user->role == Staff::ROLE_TEACHER){
                    return $next($request);
                }
            }
            return abort(403);
        } catch (\Exception $e) {
            Log::error('Error middleware permission for staff', [
                'method' => __METHOD__,
                'message' => $e->getMessage(),
                'user_id' => Auth::guard('admin')->id(),
            ]);
            return abort(403);
        }
    }
}
