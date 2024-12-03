<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Jobs\sendContactMail;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function sendContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'message' => $request->input('message'),
        ];

        sendContactMail::dispatch($data);

        return redirect()->route('home_page')->with(['alert' => [
            'type' => 'success',
            'title' => 'Thành công',
            'content' => 'Gửi liên hệ thành công'
        ]]);
    }
}
