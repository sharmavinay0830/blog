<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cookie;
use Config;
use DB;
use Crypt;

class Blog extends Model
{
	protected $table = "blog";
	public function getBlogData($searchItem="")
	{
		$query = DB::table('blog')
						->select('blog.*', 'admin_user.admin_user_name')
						->join('admin_user', 'admin_user.admin_user_id', '=', 'blog.created_by');

		if(isset($searchItem['name']))
		{
			$query->where('blog.title', 'like', '%'.$searchItem['name'].'%');
		}
		$query->orderby('blogid', 'desc');
		return $query->paginate(5);		
	}
	public function checkDuplicateRecord($getInputValue)
	{
		return DB::table('blog')
							->where('blog.title', '=', $getInputValue['title'])
							->get()
							->count();
	}
	public function checkDuplicateRecordEdit($getInputValue)
	{
		return DB::table('blog')
							->where('blog.title', '=', $getInputValue['title'])
							->where('blog.blogid', '!=', $getInputValue['blogid'])
							->get()
							->count();
	}
	public function insertBlogData($getInputValue, $imagePath)
	{
		return DB::table('blog')->insertGetId(
			[
				'title' => $getInputValue['title'],
				'blogimage' => $imagePath,
				'content_text' => $getInputValue['content_text'],
				'create_date' => NOW(),
				'created_by' => Cookie::get('aid'),
				'status' => $getInputValue['status']
			]
		);
	}
	public function getBlogDataByID($id)
	{
		$data =	DB::table('blog')
					->where('blogid', '=', $id)
					->first();
		return $data;
	}
	public function deleteBlogDataByID($id)
	{
		return DB::table('blog')->where('blogid', $id)->delete();
	}
	public function updateBlogData($getInputValue, $imagePath)
	{
		return DB::table('blog')
				->where('blogid', $getInputValue['blogid'])
				->update(
							[
								'title' => $getInputValue['title'],
								'blogimage' => $imagePath,
								'content_text' => $getInputValue['content_text'],
								'modified_by' => Cookie::get('aid'),
								'status' => $getInputValue['status'],
								'update_date' => NOW()
							]
						);
	}
}
