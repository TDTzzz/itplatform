<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('topics','TopicsController@index')->middleware('api');

//Route::post('/question/follower','QuestionFollowController@follower')->middleware('auth:api');
Route::post('/question/follower',function (Request $request){
    if (Auth::user()->followed($request->get('question'))){
        return response()->json(['followed'=>true]);
    }else{
        return response()->json(['followed'=>false]);
    }
})->middleware('auth:api');
//Route::post('/question/follow','QuestionFollowController@followThisQuestion')->middleware('auth:api');
Route::post('/question/follow',function (Request $request){
    $question=\App\Question::find($request->get('question'));
    $followed=Auth::user()->followThis($question->id);
    if(count($followed['detached'])>0){//detached是啥
        $question->decrement('followers_count');
        return response()->json(['followed'=>false]);
    }
    $question->increment('followers_count');

    return response()->json(['followed'=>true]);
})->middleware('auth:api');

Route::post('/post/follower',function (Request $request){
    if (Auth::user()->postFollowed($request->get('post'))){
        return response()->json(['followed'=>true]);
    }else{
        return response()->json(['followed'=>false]);
    }
})->middleware('auth:api');
Route::post('/post/follow',function (Request $request){
    $post=\App\Post::find($request->get('post'));
//    dd($post);
    $followed=Auth::user()->postFollowThis($post->id);
    if(count($followed['detached'])>0){//detached是啥
        $post->decrement('followers_count');
        return response()->json(['followed'=>false]);
    }
    $post->increment('followers_count');
    return response()->json(['followed'=>true]);
})->middleware('auth:api');
//notice数
Route::post('/countNotice',function (Request $request){
    $notice=DB::table('notifications')->where('notifiable_id',$request->get('user'))->whereNull('read_at')->count();
//    dd($notice);
    return response()->json(['count'=>$notice]);
})->middleware('auth:api');


Route::get('/user/followers/{id}','FollowController@index');
Route::post('/user/follow','FollowController@follow');
//vote
Route::post('answer/{id}/votes/users','VoteController@index');
Route::post('answer/vote','VoteController@vote');
//message
Route::post('/message/store','MessageController@store');
//Comment
Route::get('answer/{id}/comments','CommentController@answer');
Route::get('question/{id}/comments','CommentController@question');
Route::post('comment','CommentController@store');


