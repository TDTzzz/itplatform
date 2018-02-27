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

Route::get('/','QuestionController@index');

Auth::routes();
Route::get('email/verify/{token}',['as' => 'email.verify', 'uses' => 'EmailController@verify']);
Route::get('/home', 'HomeController@index')->name('home');
//Quesion
Route::resource('question','QuestionController',['names'=>[
    'create'=>'question.create',
    'show'=>'question.show',
]]);

Route::post('question/{id}/answer','AnswerController@store');

Route::get('question/{question}/follow','FollowController@follow');

Route::get('notification','NotificationController@index');
Route::get('notification/{notification}','NotificationController@show');
//
Route::get('inbox','InboxController@index');
Route::get('inbox/{userId}','InboxController@show');
Route::post('inbox/{dialogId}/store','InboxController@store');

Route::get('avatar','UserController@avatar');
Route::post('avatar','UserController@changeAvatar');
//
Route::get('user/{id}','UserController@user');
Route::get('user/{id}/question','UserController@question');
Route::get('user/{id}/post','UserController@post');
Route::get('user/{id}/followQuestion','UserController@followQuestion');
Route::get('user/{id}/followPost','UserController@followPost');
Route::get('user/{id}/followers','UserController@followUser');
Route::get('user/{id}/followed','UserController@followed');
//
Route::post('topic/select','TopicsController@select');
Route::get('topic/select/{order}/{old_topic}','TopicsController@selectQuestion');
//Route::get('topic/select/post/{old_topic}','TopicsController@selectPost');
Route::get('topic/{topic}','TopicsController@show');
Route::post('question/select','QuestionController@select');
//文章模块
Route::resource('post','PostController',['names'=>[
    'create'=>'post.create',
    'show'=>'post.show',
]]);
Route::post('post/{id}/comment','PostController@comment');

//图片上传
Route::post('question/upload_image', 'QuestionController@uploadImage')->name('question.upload_image');
Route::post('post/upload_image', 'PostController@uploadImage')->name('post.upload_image');

//答题模块
Route::get('/test/{type}','TestController@show');
Route::get('/totalTest','TestController@totalShow');


