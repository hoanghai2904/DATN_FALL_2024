<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Contact;

class NotificationMiddleware
{
    public function handle($request, Closure $next)
    {
        // Lấy các thông báo chưa đọc từ cơ sở dữ liệu
        $unreadMessages = Contact::where('status_contacts', 'Chưa giải quyết')->get(['id', 'name', 'message', 'created_at']);
        $unreadResponses = Contact::where('status_contacts', 'Đã phản hồi')->get(['id', 'name', 'response_message as message', 'created_at']);
        $unreadCount = $unreadMessages->count() + $unreadResponses->count();

        // Chia sẻ thông báo với tất cả các view
        view()->share('unreadCount', $unreadCount);
        view()->share('unreadMessages', $unreadMessages);
        view()->share('unreadResponses', $unreadResponses);

        return $next($request); // Tiếp tục xử lý nếu không phải yêu cầu đánh dấu
    }
}
