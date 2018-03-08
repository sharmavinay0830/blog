<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Cookie;
use Config;
use DB;
use App\Models\Common;

class CommonController extends Controller
{
	public function authCheck()
	{
		if(Cookie::get('sk')!=md5(Config::get('app.SECURITYKEY').'|'.base64_decode(Cookie::get('email')).'|'.Cookie::get('rn'))){
			return true; //redirect('login');
		}
	}
}
