<?php
use App\Http\Controllers\CommonController as CommonController;
namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Common;	
use Illuminate\Http\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Cookie;
use Config;
use DB;
use Crypt;

class BlogController extends Controller
{
	public $data;
	protected $ModuleID = 2;
	public function __construct()
	{
		// check login on load
		if(Cookie::get('aid')){
			$userID = Crypt::decrypt(Cookie::get('aid'));

			$data['superadmin'] = DB::table('admin_user')->where(['admin_user_id' => $userID, 'superadmin' => 1])->count();

			$isLogin = DB::table('admin_user')->select('status')->where(['admin_user_id' => $userID])->first();
			if($isLogin->status == 0){
				Redirect::to('logoutCMS')->send();
			}
        }
		$data['CommonController'] = new CommonController;
		$this->data = $data;
	}
	public function manageBlog()
	{
		// login check
		if($this->data['CommonController']->authCheck()==1)
		{
			return redirect('login');
		}
		$data['superadmin'] = $this->data['superadmin'];
		$Blog = new Blog;
		$searchItem = Input::all();
		$data['searchItem'] = $searchItem;	
		$data['UploadPath'] = Config::get('app.BlogImage');	
		if(!empty($searchItem)) {
			$data['GetBlogData'] = $this->searchBlog();	
		} else {
			$data['GetBlogData'] = $Blog->getBlogData();
		}
		return view('manageBlog', $data);
		
	}
	public function searchBlog()
	{	
		// login check
		if($this->data['CommonController']->authCheck()==1)
		{
			return redirect('login');
		}
		$Blog = new Blog;
		$searchItem = Input::all();
		return $data['GetBlogData'] = $Blog->getBlogData($searchItem);
	}
    public function addBlog()
	{	
		// login check
		if($this->data['CommonController']->authCheck()==1)
		{
			return redirect('login');
		}
		// check login user superadmin or not
		if($this->data['superadmin']==0)
		{
			return redirect('dashboard')->with('warning', "You don't have permission to access this page");
		}
		
		return view('addBlog');
	}
	public function insertBlog(Request $request)
	{
		// login check
		if($this->data['CommonController']->authCheck()==1)
		{
			return redirect('login');
		}
		// check login user superadmin or not
		if($this->data['superadmin']==0)
		{
			return redirect('dashboard')->with('warning', "You don't have permission to access this page");
		}
		$Blog = new Blog;
		$UploadPath = Config::get('app.BlogImage');
		$validatedData = $request->validate([
			'title' => 'required',
			'blogimage' => 'required|image|mimes:jpg,jpeg,png|max:20480',
			'content_text' => 'required',
			'status' => 'required',
		]);
		
		$getInputValue = Input::all();

		// rename image name and move to folder
		if(Input::hasFile('blogimage')){
			$getimageName = md5(time()).'.'.$request->blogimage->getClientOriginalExtension();
			$request->blogimage->move(public_path($UploadPath), $getimageName);		
		}
		
		$checkDuplicateRecord = $Blog->checkDuplicateRecord($getInputValue);
		if($checkDuplicateRecord<=0)
		{
			$id = $Blog->insertBlogData($getInputValue, $getimageName);
			if($id) {
				return redirect('manage-blog')->with('success', 'Blog Added Successfully');
			} else {
				return redirect('add-blog')->with('warning', 'Something went wrong, Please try again');
			}
		}
		else{
			return redirect('add-blog')->with('warning', 'Duplicate Blog Name Found');
		}
	}
	public function editBlog(Request $request)
    {
		// login check
		if($this->data['CommonController']->authCheck()==1)
		{
			return redirect('login');
		}
		// check login user superadmin or not
		if($this->data['superadmin']==0)
		{
			return redirect('dashboard')->with('warning', "You don't have permission to access this page");
		}
		$Blog = new Blog;

		// If ID is 0 then return to manage Blog page
		if($request->id <= 0){
			return redirect('manage-blog');
		}
		
		$data['id'] = $request->id;
		$data['UploadPath'] = Config::get('app.BlogImage');
		$data['GetBlogData'] = $Blog->getBlogDataByID($request->id);
		
        return view('editBlog', $data);
	}
	public function deleteBlog(Request $request)
    {
		// login check
		if($this->data['CommonController']->authCheck()==1)
		{
			return redirect('login');
		}
		// check login user superadmin or not
		if($this->data['superadmin']==0)
		{
			return redirect('dashboard')->with('warning', "You don't have permission to access this page");
		}
		$Blog = new Blog;

		// If ID is 0 then return to manage Blog page
		if($request->id <= 0){
			return redirect('manage-blog');
		}
		
		$data['id'] = $request->id;
		$id = $Blog->deleteBlogDataByID($request->id);
		if($id) {
			return redirect('manage-blog')->with('success', 'Blog Deleted Successfully');
		} else {
			return redirect('manage-blog')->with('warning', 'Something went wrong, Please try again');
		}
        return view('editBlog', $data);
    }
	public function updateBlog(Request $request)
    {
		// login check
		if($this->data['CommonController']->authCheck()==1)
		{
			return redirect('login');
		}
		// check login user superadmin or not
		if($this->data['superadmin']==0)
		{
			return redirect('dashboard')->with('warning', "You don't have permission to access this page");
		}
		$Blog = new Blog;
		$UploadPath = Config::get('app.BlogImage');

		$validatedData = $request->validate([
			'title' => 'required',
			'content_text' => 'required',
			'status' => 'required',
		]);
		
		$getInputValue = Input::all();
		$getimageName = $getInputValue['blogimage_old'];
		
		if(!empty($getInputValue['blogimage']))
		{
			$getimageName = md5(time()).'.'.$request->blogimage->getClientOriginalExtension();
			$request->blogimage->move(public_path($UploadPath), $getimageName);		
		}

		$checkDuplicateRecord = $Blog->checkDuplicateRecordEdit($getInputValue);
		if($checkDuplicateRecord<=0)
		{
			$id = $Blog->updateBlogData($getInputValue, $getimageName);
			if($id>=0) {
				return redirect('manage-blog')->with('success', 'Blog Updated Successfully');
			} else {
				return redirect('edit-blog/'.$getInputValue['blogid'])->with('warning', 'Something went wrong, Please try again');
			}
		}
		else{
			return redirect('edit-blog/'.$getInputValue['blogid'])->with('warning', 'Duplicate Blog Name Found');
		}
    }
}
