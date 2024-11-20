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
  public function new(Request $request)
  {
    return view('admin.post.new');
  }
  public function save(Request $request)
  {

    $validator = Validator::make($request->all(), [
      'title' => 'required',
      'content' => 'required',
      'image' => 'required',
    ], [
      'title.required' => 'Tiêu đề bài viết không được để trống!',
      'content.required' => 'Nội dung bài viết không được để trống!',
      'image.required' => 'Hình ảnh hiển thị bài viết phải được tải lên!',
    ]);
    
    if ($validator->fails()) {
      return back()
        ->withErrors($validator)
        ->withInput();
    }

    //Xử lý Ảnh trong nội dung
    $content = $request->content;

    $dom = new \DomDocument();

    // conver utf-8 to html entities
    $content = mb_convert_encoding($content, 'HTML-ENTITIES', "UTF-8");

    $dom->loadHtml($content, LIBXML_HTML_NODEFDTD);

    $images = $dom->getElementsByTagName('img');

    foreach($images as $k => $img){

        $data = $img->getAttribute('src');

        if(Str::containsAll($data, ['data:image', 'base64'])){

            list(, $type) = explode('data:image/', $data);
            list($type, ) = explode(';base64,', $type);

            list(, $data) = explode(';base64,', $data);

            $data = base64_decode($data);

            $image_name= time().$k.'.'.$type;

            Storage::disk('public')->put('images/posts/'.$image_name, $data);

            $img->removeAttribute('src');
            $img->setAttribute('src', '/storage/images/posts/'.$image_name);
        }
    }

    $content = $dom->saveHTML();

    //conver html-entities to utf-8
    $content = mb_convert_encoding($content, "UTF-8", 'HTML-ENTITIES');

    //get content
    list(, $content) = explode('<html><body>', $content);
    list($content, ) = explode('</body></html>', $content);

    $post = new Post;
    $post->title = $request->title;
    $post->content = $content;
    $post->user_id = Auth::user()->id;

    if($request->hasFile('image')){
      $image = $request->file('image');
      $image_name = time().'_'.$image->getClientOriginalName();
      $image->storeAs('images/posts',$image_name,'public');
      $post->image = $image_name;
    }

    $post->save();

    return redirect()->route('admin.post.index')->with(['alert' => [
      'type' => 'success',
      'title' => 'Thành Công',
      'content' => 'Bài viết của bạn đã được tạo thành công.'
    ]]);
  }


}
