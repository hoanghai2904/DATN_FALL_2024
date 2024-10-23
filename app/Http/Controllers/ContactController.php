<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        // Khởi tạo query để lọc liên hệ
        $query = Contact::query();
    
        // Lọc theo trạng thái liên hệ
        if ($request->filled('status_contacts')) {
            $query->where('status_contacts', $request->status_contacts);
        }
    
        // Lọc theo email
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }
    
        // Lọc theo tên khách hàng
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
    // Khoảng thời gian
    if ($request->filled('start_date') && $request->filled('end_date')) {
        // Chuyển đổi định dạng ngày để phù hợp
        $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', $request->start_date)->startOfDay();
        $endDate = \Carbon\Carbon::createFromFormat('Y-m-d', $request->end_date)->endOfDay();

        // Lọc theo khoảng thời gian
        $query->whereBetween('created_at', [$startDate, $endDate]);
    }

        // Lọc theo tìm kiếm chung
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')   
                  ->orWhere('phone', 'like', '%' . $search . '%')
                  ->orWhere('message', 'like', '%' . $search . '%')
                  ->orWhere('status_contacts', 'like', '%' . $search . '%');
            });
        }
    
        // Lấy danh sách liên hệ với phân trang
        $contacts = $query->orderBy('created_at', 'desc')->paginate(10);
    
        // Trả về view danh sách liên hệ
        return view('admin.contacts.index', compact('contacts'));
    }
    

    public function create()
    {
        return view('admin.contacts.create'); // Trả về view tạo mới
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:15',
            'message' => 'nullable|string',
        ]);

        Contact::create($request->all()); // Lưu thông tin liên hệ
        return redirect()->route('admin.contacts.index')->with('success', 'Liên hệ đã được tạo thành công!');
    }

    public function show($id)
    {
        $contact = Contact::findOrFail($id); // Lấy thông tin liên hệ theo ID
        return view('admin.contacts.show', compact('contact')); // Trả về view hiển thị
    }

    public function edit(Contact $contact)
    {
        return view('admin.contacts.edit', compact('contact')); // Trả về view và truyền biến $contact
    }

    public function update(Request $request, Contact $contact)
    {
        $request->validate([
            'status_contacts' => 'required|string|in:Chưa phản hồi,Đã phản hồi',
        ]);

        // Cập nhật trạng thái
        $contact->update([
            'status_contacts' => $request->status_contacts,
        ]);

        return redirect()->route('admin.contacts.index')->with('success', 'Trạng thái liên hệ đã được cập nhật thành công!');
    }

    public function reply($id)
    {
        $contact = Contact::findOrFail($id);
        return view('admin.contacts.reply', compact('contact'));
    }

    public function sendResponse(Request $request, $id)
    {
        $request->validate([
            'response_message' => 'required|string|max:500',
        ]);
    
        $contact = Contact::findOrFail($id);
    
        $data = [
            'name' => $contact->name,  // Lấy tên từ bản ghi liên hệ
            'email' => $contact->email,  // Lấy email từ bản ghi liên hệ
            'message' => $request->input('response_message'), // Nội dung phản hồi
        ];
    
        // Kiểm tra nếu email tồn tại
        if (!empty($data['email'])) {
            // Gửi email phản hồi
            Mail::send('Mail.contact_response', compact('data'), function ($message) use ($data) {
                $message->to($data['email'])
                        ->subject('Phản hồi liên hệ');
            });
        } else {
            // Xử lý khi email không hợp lệ
            return back()->with('error', 'Không thể gửi phản hồi vì email không tồn tại.');
        }
    
        // Cập nhật trạng thái liên hệ thành "Đã liên hệ" sau khi gửi phản hồi
        $contact->update([
            'status_contacts' => 'Đã phản hồi',
        ]);
    
        return redirect()->route('admin.contacts.index')->with('success', 'Phản hồi đã được gửi thành công và trạng thái đã được cập nhật!');
    }

    public function destroy($id)
    {

        $contact = Contact::find($id);
        if ($contact) {
            $contact->delete();
            return response()->json(['status' => 'success', 'message' => 'Đơn hàng đã được xóa!']);
        }
        return response()->json(['status' => 'error', 'message' => 'Không tìm thấy đơn hàng!']);
    }
}