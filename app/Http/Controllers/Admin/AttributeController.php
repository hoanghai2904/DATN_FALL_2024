<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AttributeController extends Controller
{
    public function index()
    {
        $attributes = Attribute::with('values')->get();
        return view('admin.attributes.index', compact('attributes'));
    }

    public function create()
    {
        return view('admin.attributes.new');
    }

    public function store(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
            'values' => 'required|array',
            'values.*.value' => 'required|string|max:255',
        ]);

        // Bắt đầu transaction để đảm bảo dữ liệu được lưu an toàn
        DB::beginTransaction();

        try {
            // Kiểm tra xem tên thuộc tính đã tồn tại chưa
            $existingAttribute = Attribute::where('name', $request->name)->first();

            // Nếu tên thuộc tính đã tồn tại, trả về lỗi
            if ($existingAttribute) {
                return response()->json([
                    'errors' => [
                        'name' => ['Tên thuộc tính đã tồn tại!'],
                    ]
                ], 422);
            }

            // Tạo mới thuộc tính
            $attribute = Attribute::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name), // Tạo slug từ tên thuộc tính
            ]);

            // Lưu các giá trị của thuộc tính, kiểm tra trùng lặp trước khi thêm
            foreach ($request->values as $valueData) {
                // Kiểm tra xem giá trị đã tồn tại chưa cho thuộc tính này
                $valueExists = AttributeValue::where('attribute_id', $attribute->id)
                    ->where('value', $valueData['value'])
                    ->exists();

                // Nếu giá trị đã tồn tại, trả về lỗi
                if ($valueExists) {
                    return response()->json([
                        'errors' => [
                            'values' => ['Giá trị "' . $valueData['value'] . '" đã tồn tại cho thuộc tính này!'],
                        ]
                    ], 422);
                }

                // Nếu giá trị chưa tồn tại, tạo mới
                AttributeValue::create([
                    'attribute_id' => $attribute->id,
                    'value' => $valueData['value'],
                ]);
            }

            // Commit transaction nếu không có lỗi
            DB::commit();

            // Trả về phản hồi JSON
            return response()->json([
                'message' => 'Thuộc tính và giá trị đã được thêm thành công!',
            ], 200);
        } catch (\Exception $e) {
            // Rollback transaction nếu có lỗi
            DB::rollback();

            // Trả về lỗi dưới dạng JSON
            return response()->json([
                'errors' => [
                    'general' => ['Đã xảy ra lỗi, vui lòng thử lại!'],
                ]
            ], 422);
        }
    }




    public function edit($id)
    {
        $attribute = Attribute::with('values')->findOrFail($id);
        // dd($attribute);
        return view('admin.attributes.edit', compact('attribute'));
    }

    // Hàm để xử lý cập nhật thuộc tính
    public function update(Request $request, $id)
    {
        $attribute = Attribute::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'values.*.value' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            // Cập nhật tên thuộc tính
            $attribute->update([
                'name' => $validatedData['name'],
            ]);

            // Xóa các giá trị cũ không được gửi lên
            $existingIds = $attribute->values->pluck('id')->toArray();
            $newIds = collect($validatedData['values'])->pluck('id')->filter()->toArray();
            $idsToDelete = array_diff($existingIds, $newIds);
            AttributeValue::whereIn('id', $idsToDelete)->delete();

            // Cập nhật hoặc thêm mới giá trị thuộc tính
            foreach ($validatedData['values'] as $valueData) {
                if (isset($valueData['id'])) {
                    // Cập nhật giá trị cũ
                    $value = AttributeValue::findOrFail($valueData['id']);
                    $value->update(['value' => $valueData['value']]);
                } else {
                    // Thêm giá trị mới
                    $attribute->values()->create(['value' => $valueData['value']]);
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'Thuộc tính đã được cập nhật thành công.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Đã xảy ra lỗi khi cập nhật thuộc tính.',
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            // Tìm thuộc tính theo ID, nếu không tìm thấy sẽ trả về lỗi 404
            $attribute = Attribute::findOrFail($id);

            // Xoá thuộc tính
            $attribute->delete();

            // Trả về phản hồi JSON thành công
            return response()->json([
                'message' => 'Thuộc tính đã được xóa!',
                'status' => 'success'
            ], 200);
        } catch (\Exception $e) {
            // Trả về phản hồi lỗi nếu xảy ra vấn đề
            return response()->json([
                'message' => 'Có lỗi xảy ra khi xoá thuộc tính!',
                'status' => 'error'
            ], 500);
        }
    }



    public function getAttributeValues($id)
    {
        // Tìm Attribute
        $attribute = Attribute::with('values')->find($id);
    
        // Kiểm tra nếu không tìm thấy thuộc tính
        if (!$attribute) {
            return response()->json(['error' => 'Thuộc tính không tồn tại'], 404);
        }
    
        // Kiểm tra nếu không có giá trị cho thuộc tính
        if ($attribute->values->isEmpty()) {
            return response()->json(['message' => 'Không có giá trị cho thuộc tính này'], 404);
        }
    
        // Trả về giá trị thuộc tính
        return response()->json([
            'values' => $attribute->values->map(function ($value) {
                return [
                    'id' => $value->id,
                    'name' => $value->value,  // Đảm bảo trường giá trị đúng
                ];
            }),
        ]);
    }
    
}
