<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\VariantType;
use App\Models\VariantValue;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $variantTypes = VariantType::all();
        return view('admin.products.variants.index', compact('variantTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $variantValues = VariantType::with('variantValues')->get();
        // dd($variantValues);
        return view('admin.products.variants.create', compact('variantValues'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([

            'name' => 'required|unique:variant_types,name',
            'status' => 'required',
        ], [

            'name.required' => 'Tên thuộc tính không được để trống',
            'name.unique' => 'Tên thuộc tính đã tồn tại',
        ]);

        $variant = VariantType::create([
            'name' => $request->name,
            'slug' => slug($request->name),
            'status' => $request->status,
        ]);

        $variantTypeId = $variant->id;

        if ($request->has('value')) {
            foreach ($request->value as $value) {
                VariantValue::create([
                    'variant_type_id' => $variantTypeId,
                    'value' => $value,
                ]);
            }
        }
        return redirect()->route('admin.variants.index')->with('success', 'Lưu thành công các giá trị thuộc tính');
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
        $variant = VariantType::with('variantValues')->findOrFail($id);
        return view('admin.products.variants.update', compact('variant'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'name' => 'required|unique:variant_types,name,' . $id, // Kiểm tra tính duy nhất
            'status' => 'required',
            'value' => 'array', // Đảm bảo giá trị là một mảng
            'value.*' => 'string', // Mỗi phần tử trong mảng phải là chuỗi
        ], [
            'name.required' => 'Tên thuộc tính không được để trống',
            'name.unique' => 'Tên thuộc tính đã tồn tại',
        ]);

        // Lấy bản ghi VariantType theo ID
        $variant = VariantType::findOrFail($id);

        // Cập nhật thông tin của VariantType
        $variant->update([
            'name' => $request->name,
            'slug' => slug($request->name),
            'status' => $request->status,
        ]);

        // Lưu trữ tất cả giá trị cũ
        $existingValues = $variant->variantValues()->pluck('value')->toArray();

        // Thêm hoặc cập nhật giá trị
        if ($request->has('value')) {
            foreach ($request->value as $value) {
                // Kiểm tra xem giá trị đã tồn tại trong cơ sở dữ liệu hay chưa
                if (in_array($value, $existingValues)) {
                    // Nếu giá trị đã tồn tại, không làm gì cả
                    continue;
                } else {
                    // Nếu giá trị chưa tồn tại, kiểm tra xem nó có trong giá trị đã xóa không
                    $deletedValue = VariantValue::onlyTrashed()->where('value', $value)->first();
                    if ($deletedValue) {
                        // Nếu giá trị đã bị xóa, khôi phục lại nó
                        $deletedValue->restore();
                    } else {
                        // Nếu giá trị chưa tồn tại và không bị xóa, thêm mới
                        VariantValue::create([
                            'variant_type_id' => $variant->id,
                            'value' => $value,
                        ]);
                    }
                }
            }
        }

        // Xóa các giá trị không còn trong mảng `value` gửi lên
        foreach ($existingValues as $existingValue) {
            if (!in_array($existingValue, $request->value ?? [])) {
                $variant->variantValues()->where('value', $existingValue)->delete();
            }
        }


        return redirect()->route('admin.variants.index')->with('success', 'Cập nhật thuộc tính sản phẩm thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $variant = VariantType::findOrFail($id);
        $variant->delete();
        return response(['status' => 'success', 'Xóa thành công!']);
    }

    public function changeStatus(Request $request)
    {
        // dd($request->id);
        $variant = VariantType::findOrFail($request->id);
        // dd($variant);
        $variant->status = $request->status == 'true' ? 1 : 0;
        $variant->save();

        return response(['message' => 'Cập nhật trạng thái thành công!']);
    }
}
