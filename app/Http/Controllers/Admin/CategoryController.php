<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Flasher\Notyf\Prime\NotyfInterface;



class CategoryController extends Controller
{

    public function show(Request $request)
    {
        $query = Category::withTrashed();
        if ($request->has('status')) {

            if ($request->status == '0') {
            } elseif ($request->status == '1') {

                $query->where('status', 1);
            } elseif ($request->status == '2') {

                $query->where('status', 0);
            }
        }
        // Phân trang
        $categories = $query->orderBy('status', 'desc')->latest()->paginate(5);
        return view('admin.list.index')->with([
            'categories' => $categories,
            'selectedStatus' => $request->status
        ]);
    }

    public function addCategory()
    {

        $category = Category::all();
        // dd($category);
        return view('admin.list.create')->with((['category' => $category]));
    }


    public function addPostCategory(Request $req)
    {
        // Kiểm tra nếu danh mục đã tồn tại
        $existingCategory = Category::where('name', $req->name)->first();

        if ($existingCategory) {
            return redirect()->back()->withErrors(['name' => 'Danh mục đã tồn tại.'])->withInput();
        }

        $req->validate([
            'name' => 'required|string|max:255|regex:/^[\p{L}\s]+$/u'
        ], [
            'name.required' => 'Tên danh mục không được để trống',
            'name.max' => 'Tên danh mục quá dài',
            'name.regex' => 'Tên danh mục phải là chuỗi ký tự'
        ]);

        $data = [
            'name' => $req->name,
            'slug' => $req->slug,
            'parent_id' => $req->parent_id
        ];
        Category::create($data);
        session()->flash('success', 'Thêm danh mục thành công!');

        return redirect()->route('admin.categories.listCategory')->with('success', 'Danh mục đã được thêm thành công.');
    }
    public function deleteCategory($id)
    {
        $category = Category::find($id);

        if ($category) {
            // Cập nhật trạng thái
            $category->status = 0;
            $category->save();

            // Xóa danh mục sau khi cập nhật trạng thái
            $category->delete();
        }

        session()->flash('success', 'Cập nhật trạng thái danh mục thành công!');

        // Chuyển hướng về trang danh sách danh mục
        return redirect()->route('admin.categories.listCategory')->with('message', 'Cập nhật trạng thái danh mục thành công');
    }

    public function restoreCategory($id)
    {
        $category = Category::withTrashed()->find($id);

        if ($category) {
            $category->status = 1;
            $category->save();

            $category->restore(); // Phục hồi danh mục
            session()->flash('success', 'Cập nhật trạng thái danh mục thành công!');

            return redirect()->route('admin.categories.listCategory');
        }

        return redirect()->route('admin.categories.listCategory')->with(['message' => 'Danh mục không tồn tại']);
    }

    public function updateCategory($id)
    {
        $category = Category::withTrashed()->find($id);
        $categories = Category::all();
        return view('admin.list.update')->with([
            'category' => $category,
            'categories' => $categories
        ]);
    }
    public function updatePutCategory(Request $req, $id)
    {
        $category = Category::withTrashed()->find($id);
        $req->validate([
            'name' => 'required|string|max:255|regex:/^[\p{L}\s]+$/u'

        ], [
            'name.required' => 'Tên danh mục không được để trống',
            'name.string' => 'Tên danh mục phải là chuỗi ký tự',
            'name.max' => 'Tên danh mục quá dài',
            'name.regex' => 'Tên danh mục phải là chuỗi ký tự'

        ]);

        $data = [
            'name' => $req->name,
            'slug' => $req->slug,
            'parent_id' => $req->parent_id
        ];

        $category->update($data);

        // Thông báo thành công khi cập nhật
        session()->flash('success', 'Cập nhật danh mục thành công!');


        return redirect()->route('admin.categories.listCategory');
    }
}
