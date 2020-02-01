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
    return view('welcome');
});


Route::get('posts/search/','postController@search');
Route::middleware('ajax.check')->group(function(){
Route::get('/posts','postController@index');
Route::get('/posts/create','postController@create');
Route::post('posts/store', 'postController@store');
Route::get('/posts/show/{id}','postController@show');
Route::get('/posts/edit/{id}','postController@edit');
Route::post('/posts/update','postController@update');
Route::get('/posts/destroy/{id}','postController@destroy');


});

Route::get('language/{lang}', function($lang){

	\Session::put('locale',$lang);

	return redirect()->back();

	})->middleware('language');

	Route::group(['middleware'=>'language'],function(){

		Auth::routes();
	});
	Route::get('verify/{email}/{token}','Auth\RegisterController@verifyUser')->name('verify');

	Route::get('notify','NotificationController@notify');