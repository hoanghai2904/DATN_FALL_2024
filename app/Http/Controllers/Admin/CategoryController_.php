<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController_ extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::query()->latest('id')->paginate(7);
        // dd($categories);
        return view('admin.categories_.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $categoryParent = Category::query()->where('parent_id', null)->get();
        $categoryParent = Category::all();
        $categories = Category::with('children')->where('parent_id')->get();
        // dd($categories);
        // dd($categoryParent);
        return view('admin.categories_.create', compact('categoryParent', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            // 'slug' => 'required|string|unique:categories,slug|max:255',
            'parent_id' => 'nullable|exists:categories,id', // Kiểm tra ID danh mục cha có tồn tại
            'status' => 'required|boolean',
        ], [
            'name.required' => 'Tên danh mục không được để trống',
            'name.string' => 'Tên danh mục phải là chuỗi ký tự',
            'name.max' => 'Tên danh mục không được vượt quá 255 ký tự',
        ]);
        $category = Category::create([
            'name' => $request->name,
            'slug' => slug($request->name),
            'status' => $request->status,
        ]);
        if ($request->has('parent_id')) {
            $category->parent()->attach($request->input('parent_id'));

        }
        return redirect()->route('admin.categories_.index')->with('success', 'Thêm thành công!');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::with('children', 'parent')->findOrFail($id);
        $categories = Category::with('children')->whereNull('parent_id')->where('id', '!=', $id)->get();
        $selectedCategories = $category->parent->pluck('id')->toArray();

        return view('admin.categories_.update', compact('category', 'categories', 'selectedCategories'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|array',
            'parent_id.*' => 'exists:categories,id',
        ]);

        $category = Category::findOrFail($id);
        $category->update(['name' => $validated['name']]);

        if (empty($validated['parent_id'])) {
            $category->parent()->detach(); // Thay thế sync bằng detach để xóa tất cả mối quan hệ
        } else {
            // Lưu các mối quan hệ cha
            $category->parent()->sync($validated['parent_id']);
        }

        return redirect()->route('admin.categories_.index')->with('success', 'Cập nhật danh mục thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response(['status' => 'success', 'Xóa thành công!']);
    }

    public function changeStatus(Request $request)
    {
        // dd($request->id);
        $category = Category::findOrFail($request->id);
        // dd($category);
        $category->status = $request->status == 'true' ? 1 : 0;
        $category->save();

        return response(['message' => 'Cập nhật trạng thái thành công!']);
    }
}
