<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect()->route('login')->with(['alert' => [
                'type' => 'warning',
                'title' => 'Từ chối truy cập!',
                'content' => 'Bạn chưa đăng nhập. Hãy đăng nhập tài khoản để tiếp tục.'
            ]]);
        }

        // Kiểm tra quyền của người dùng
        if (Auth::user()->Role == 2) {
            if ($request->ajax() || $request->wantsJson()) {
                // Nếu yêu cầu là AJAX hoặc mong muốn JSON, trả về JSON
                return response()->json([
                    'type' => 'error',
                    'title' => 'Từ chối truy cập!',
                    'content' => 'Tài khoản của bạn không có quyền truy cập hành động này .'
                ], 403);
            } else {
                // Nếu không phải yêu cầu AJAX, chuyển hướng về trang HTML
                return redirect()->route('admin.dashboard')->with(['alert' => [
                    'type' => 'warning',
                    'title' => 'Từ chối truy cập!',
                    'content' => 'Tài khoản của bạn không có quyền truy cập vào trang này.'
                ]]);
            }
        }

        // Nếu tất cả kiểm tra đều đúng, cho phép tiếp tục yêu cầu
        return $next($request);
    }
}
