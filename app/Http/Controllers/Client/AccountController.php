<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountController extends Controller
{
     public function login(){
        return view('Client.Login');
     }

     public function check_login(){
  
   }

   public function rigester(){
      return view('Client.Rigester');
   }

   public function check_rigester(){
 
 }

 public function profile(){
   return view('Client.Login');
}

public function check_profile(){

}

public function change_pass(){
   return view('Client.Login');
}

public function Check_changePass(){

}

public function forgot_pass(){
   return view('Client.Login');
}

public function Check_forgotPass(){

}

public function reset_pass(){
   return view('Client.Login');
}

public function Check_resetPass(){

}

}
