<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brands extends Model
{
    use HasFactory,SoftDeletes;

    protected $filable = [
        'logo',
        'name',
        'slug',
];
    public $table = 'brands';
    public $timestamp = false;
    public function createBrands($data) 
    {
        DB::table('brands')->insert($data);
    }
    public function updateBrands($data, $id) 
    {
        DB::table('brands')
        ->where('id', $id)
        ->update($data);  
    }
}
