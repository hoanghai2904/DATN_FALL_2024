<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use App\Models\Post;

class PostController extends Controller
{
  public function index(Request $request)
  {
    $posts = Post::select('id', 'title', 'image','status', 'created_at')->latest()->get();
    return view('admin.post.index')->with('posts', $posts);
  }



}
