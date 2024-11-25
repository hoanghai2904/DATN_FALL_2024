<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

use App\Models\Advertise;

class AdvertiseController extends Controller
{
  public function index()
  {
    $advertises = Advertise::select('id', 'title', 'image', 'at_home_page', 'start_date', 'end_date', 'created_at')->latest()->get();
    return view('admin.advertise.index')->with('advertises', $advertises);
  }
  public function new()
  {
    return view('admin.advertise.new');
  }

}
