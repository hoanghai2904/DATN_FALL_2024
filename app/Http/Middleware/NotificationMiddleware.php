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

        // Kiểm tra nếu có yêu cầu để đánh dấu thông báo đã đọc
        if ($request->isMethod('post') && $request->routeIs('notifications.markAsRead')) {
            $messageId = $request->input('message_id'); // Đổi tên thành message_id để dễ hiểu hơn

            $contact = Contact::find($messageId);
            if ($contact) {
                $contact->status_contacts = 'Đã đọc'; // Cập nhật trạng thái
                $contact->save(); // Lưu thay đổi

                // Cập nhật lại số lượng thông báo chưa đọc
                $unreadCount = Contact::where('status_contacts', 'Chưa giải quyết')->count();
                return response()->json(['unreadCount' => $unreadCount]); // Trả về số lượng mới
            } else {
                return response()->json(['error' => 'Thông báo không tồn tại.'], 404); // Trả về lỗi nếu không tìm thấy
            }
        }

        return $next($request); // Tiếp tục xử lý nếu không phải yêu cầu đánh dấu
    }
}
