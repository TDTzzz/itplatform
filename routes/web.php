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
//
Route::get('inbox','InboxController@index');
Route::get('inbox/{userId}','InboxController@show');
Route::post('inbox/{dialogId}/store','InboxController@store');

