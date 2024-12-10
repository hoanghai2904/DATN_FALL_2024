<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Advertise;

class ContactPage extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $advertises = Advertise::where([
          ['start_date', '<=', date('Y-m-d')],
          ['end_date', '>=', date('Y-m-d')],
          ['at_home_page', '=', false]
        ])

        return view('pages.contact')->with(['advertises' => $advertises]);
    }
}
