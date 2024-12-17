<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Producer;
use Illuminate\Http\Request;

class ProducerController extends Controller
{
    public function index()
    {
        $producers = Producer::paginate(10);
        return view('admin.producer.index', ['producers' => $producers]);
    }

    public function new()
    {
        return view('admin.producer.new');
    }

    public function save(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);

        Producer::create($validated);

        return redirect()->route('admin.producer.index')->with(['alert' => [
            'type' => 'success',
            'title' => 'Thành Công',
            'content' => 'Thêm danh mục thành công.'
        ]]);
    }

    public function delete(Request $request)
    {
        $producer = Producer::find($request->input('producer_id'));
        if (!$producer) {
            return response()->json([
                'type' => 'error',
                'title' => 'Thất Bại',
                'content' => 'Danh mục không tồn tại.'
            ]);
        }
        if ($producer->products()->count() > 0) {
            return response()->json([
                'type' => 'error',
                'title' => 'Thất Bại',
                'content' => 'Không thể xóa danh mục đã có sản phẩm.'
            ]);
        }
        $producer->delete();

        return response()->json([
            'type' => 'success',
            'title' => 'Thành Công',
            'content' => 'Xóa danh mục thành công.'
        ]);
    }

    public function edit($id)
    {
        $producer = Producer::find($id);

        return view('admin.producer.edit', ['producer' => $producer]);
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required',
            ]);

            $producer = Producer::find($id);
            if (!$producer) {
                return redirect()->route('admin.producer.index')->with(['alert' => [
                    'type' => 'error',
                    'title' => 'Thất Bại',
                    'content' => 'Danh mục không tồn tại.'
                ]]);
            }
            $producer->update($validated);
            return redirect()->route('admin.producer.index')->with(['alert' => [
                'type' => 'success',
                'title' => 'Thành Công',
                'content' => 'Cập nhật danh mục thành công.'
            ]]);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
