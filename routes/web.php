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

/*route pages */
Route::get('/', "PagesController@index");
Route::get('/register', "PagesController@userregistration");
Route::get('/login', "PagesController@login");
Route::get('/home', "PagesController@home");
Route::get('/profile', "PagesController@profile");
Route::get('/Logout', "PagesController@Logout");
Route::get('/userProfile/{id}', "PagesController@userProfile");
Route::get('/editProfileDetails', "PagesController@editProfileDetails");
Route::get('/removeSession', "PagesController@removeSession");

/*user routes */
Route::post('/registerUser', "CustomAuth\userRegistrationController@registerUser");
Route::post('/uploadPicture', "CustomAuth\userRegistrationController@uploadPicture");
Route::post('/LoginUser', "CustomAuth\userLogin@LoginUser");
Route::post('/updateUser', "CustomAuth\userRegistrationController@updateUser");


/*user post*/
Route::post('/createPost', "PostController\PostController@createPost");
Route::get('/getStoryByUser/{id}', "PostController\PostController@getStoryByUser");
Route::get('/getStory', "PostController\PostController@getStory");
Route::get('/deletePost/{id}', "PostController\PostController@deletePost");
Route::get('/getUserPost/{id}', "PostController\PostController@getUserPost");
Route::post('/updatePost', "PostController\PostController@updatePost");
Route::post('/likeStory', "PostController\PostController@likeStory");
/*author profile */
Route::get('/getUserProfile/{author}', "UserProfile\userProfileController@getUserProfile");
Route::post('/countVisitor', "UserProfile\userProfileController@countVisitor");