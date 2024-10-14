<?php

namespace App\Http\Controllers;

use App\Http\Requests\BannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Flasher\Notyf\Prime\NotyfInterface;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function listBanner()
    {
        $listBanner = Banner::paginate(5); // Lấy 10 banner mỗi trang
        return view('admin.banners.list-banner')->with(['listBanner' => $listBanner]);
    }
    public function addBanner()
    {
        return view('admin.banners.add-banner');
    }

    // Phương thức để xử lý thêm mới banner
    public function addPostBanner(BannerRequest $request)
    {
        $path = null;
        if ($request->hasFile('banner')) {
            $image = $request->file('banner');
            $newImage = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('images', $newImage, 'public');
        }

        $data = [
            'banner' => $path,
            'url' => $request->url,
            'status' => $request->status,
        ];

        Banner::create($data);
        notyf()->info('Your account has been deactivated and a confirmation email has been sent.');
        return redirect()->route('admin.banners.listBanner')->with(['message' => 'Thêm Mới Thành Công']);
    }

    // Phương thức để hiển thị chi tiết banner
    public function detailBanner($idBanner)
    {
        $banner = Banner::where('id', $idBanner)->first();
        return view('admin.banners.detail-banner')->with(['banner' => $banner]);
    }
    public function updateBanner($id)
    {
        $banner = Banner::find($id);
        return view('admin.banners.update-banner')->with(['banner' => $banner]);
    }
    public function updatePutBanner(UpdateBannerRequest $request, $id)
    {
        $banner = Banner::find($id);
        $path = $banner->banner; // Save the current image path
        if ($request->hasFile('banner')) {
            // Delete the old banner image from storage
            Storage::disk('public')->delete($banner->banner);

            // Store the new banner image
            $image = $request->file('banner');
            $newImage = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('images', $newImage, 'public');
        }

        // Prepare the data for updating
        $data = [
            'banner' => $path,
            'url' => $request->url,
            'status' => $request->status,
        ];

        // Update the banner with the new data
        $banner->update($data);

        // Redirect to the list of banners
        return redirect()->route('admin.banners.listBanner')->with(['message' => 'Sửa Thành Công']);
    }

    public function deleteBanner($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();
        return response(['status' => 'success', 'Xóa thành công!']);
    }
    public function changeStatus(Request $request)
    {
        // dd($request->id);
        $product = Banner::findOrFail($request->id);
        // dd($product);
        $product->status = $request->status == 'true' ? 1 : 0;
        $product->save();

        return response(['message' => 'Cập nhật trạng thái thành công!']);
    }
    
}
