<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        // Kiểm tra quyền từ session
        if (!in_array($permission, session('user_permissions', []))) {
            return redirect()->route('dashboard')
                ->withErrors(['Bạn không có quyền thực hiện hành động này.']);
        }

        // Nếu có quyền, tiếp tục hành động
        return $next($request);
    }
}
