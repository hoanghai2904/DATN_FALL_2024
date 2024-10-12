<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactResponseMail;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::all(); // Lấy tất cả thông tin liên hệ
        return view('admin.contacts.index', compact('contacts')); // Trả về view
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
            'status_contacts' => 'required|string|in:Chưa giải quyết,Đã liên hệ',
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
        
        // Gửi email phản hồi
        Mail::to($contact->email)->send(new ContactResponseMail($contact, $request->response_message));
    
        // Cập nhật trạng thái liên hệ thành "Đã liên hệ" sau khi gửi phản hồi
        $contact->update([
            'status_contacts' => 'Đã liên hệ',
        ]);
    
        return redirect()->route('admin.contacts.index')->with('success', 'Phản hồi đã được gửi thành công và trạng thái đã được cập nhật!');
    }
    
    

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id); // Tìm thông tin liên hệ
        $contact->delete(); // Xóa thông tin liên hệ
        return redirect()->route('admin.contacts.index')->with('success', 'Liên hệ đã được xóa thành công!');
    }
}
