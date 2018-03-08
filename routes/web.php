<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('login');
});

// login page view
Route::get('/login', 'authController@login');

// login page post value
Route::post('/loginme', 'authController@authUser');

// logout page
Route::get('/logoutCMS', 'authController@logout');

// after login show dashboard page
Route::get('/dashboard', 'authController@dashboard');

// Manage Blog Page
Route::get('/manage-blog', 'BlogController@manageBlog');

// Add Blog Page
Route::get('/add-blog', 'BlogController@addBlog');

// Insert Blog
Route::post('/insertBlog', 'BlogController@insertBlog');

// Edit Blog
Route::get('/edit-blog/{id}', 'BlogController@editBlog');

// Delete Blog
Route::get('/delete-blog/{id}', 'BlogController@deleteBlog');

// Update Blog
Route::post('/updateBlog', 'BlogController@updateBlog');