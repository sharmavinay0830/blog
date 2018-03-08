<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Cookie;
use Config;
use DB;
use Crypt;
use Redirect;

class authController extends Controller
{
	public function dashboard()
	{
		if(Cookie::get('sk')==md5(Config::get('app.SECURITYKEY').'|'.base64_decode(Cookie::get('email')).'|'.Cookie::get('rn')))
		{
			return view('dashboard_list');
		}
		else
		{
			return redirect('/login');
		}
	}
	public function login()
	{
		if(Cookie::get('sk')==md5(Config::get('app.SECURITYKEY').'|'.base64_decode(Cookie::get('email')).'|'.Cookie::get('rn'))){
			return redirect('dashboard');
		}
		else{
			Cookie::queue(Cookie::forget('aid'));
			Cookie::queue(Cookie::forget('sk'));
			Cookie::queue(Cookie::forget('rn'));
			Cookie::queue(Cookie::forget('email'));
			Cookie::queue(Cookie::forget('admin_user_name'));
			return view('login');
		}
	}
	public function authUser(request $request)
	{
		$uemail  = $request->input('useremail');
		$upass  =  $request->input('password');

		$validatedData = $request->validate([
							'useremail' => 'required',	
							'password' => 'required',
						]);

		$upass = md5($upass);
		if($validatedData)
		{			
			$isLogin = DB::table('admin_user')->where(['admin_email' => $uemail, 'admin_password' => $upass, 'status' => 1])->first();
			if(count($isLogin) > 0)
			{
				$admin_user_name = $isLogin->admin_user_name;
				$random_number = rand(0, 999999); // 6 digit random number Ex. 456457
				$aid = $isLogin->admin_user_id;
				$securityKey = Config::get('app.SECURITYKEY');
				$newSecurityKey = $securityKey.'|'.$uemail.'|'.$random_number;
				$newSecurityKeyEncrypted = md5($securityKey.'|'.$uemail.'|'.$random_number);
				$uemailEncodeed =  base64_encode($uemail);
				
				// set cookies
				Cookie::queue('aid', $aid);
				Cookie::queue('email', $uemailEncodeed);
				Cookie::queue('rn', $random_number);
				Cookie::queue('sk', $newSecurityKeyEncrypted);
				Cookie::queue('admin_user_name', $admin_user_name);
				
				return redirect('/dashboard');
			}
			else
			{
				return redirect('/login')->with('warning', 'Invalid Credential');
			}
		}
		else
		{
			return redirect('/login')->with('warning', 'Invalid Credential');
		}
	}
	public function logout()
	{
		Cookie::queue(Cookie::forget('aid'));
		Cookie::queue(Cookie::forget('sk'));
		Cookie::queue(Cookie::forget('rn'));
		Cookie::queue(Cookie::forget('email'));
		Cookie::queue(Cookie::forget('admin_user_name'));
		return redirect('/login');
	}
}	