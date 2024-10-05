<?php

namespace App\Http\Controllers;

use App\Models\Brands;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BrandsController extends Controller
{
    public $brands;
    public function __construct()
    {
        $this->brands = new Brands();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listBrands = Brands::all();
        return view('admin.brands.index', ['brands' => $listBrands]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brands.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->hasFile('logo')) {
            $filename = $request->file('logo')->store('uploads/brands', 'public');
        } else {
            $filename = null;
        }

        $dataInsert = [
            'logo' => $filename,
            'name' => $request->name,
            'slug' => $request->slug,
        ];
        $this->brands->createBrands($dataInsert);
        return redirect()->route('admin.brands.index');
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
        $brands = $this->brands->find($id);

        if (!$brands) {
            return redirect()->route('brands.index');
        }
        return view('admin.brands.update', compact('brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $brands = $this->brands->find($id);
        if ($request->hasFile('logo')) {
            if ($brands->logo) {
                Storage::disk('public')->delete($brands->logo);
            }
            //lưu ảnh mới
            $filename = $request->file('logo')->store('uploads/brands', 'public');
        } else {
            $filename = $brands->logo;
        }

        $dataUpdate = [
            'logo' => $filename,
            'name' => $request->name,
            'slug' => $request->slug,
        ];

        $brands->updateBrands($dataUpdate, $id);
        return redirect()->route('admin.brands.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brands = $this->brands->find($id);
        if (!$brands) {
            return redirect()->route('admin.brands.index');
        }
        if ($brands->logo) {
            Storage::disk('public')->delete($brands->logo);
        }
        $brands->delete();
        return redirect()->route('admin.brands.index');
    }
}
