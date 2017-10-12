<?php

namespace App\Http\Controllers;

use App\Notifications\NewUserNotification;
use Auth;
use App\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{

    public function index($id)
    {
        $user=User::find($id);
        $followers=$user->followersUser()->pluck('follower_id')->toArray();
        if (in_array(Auth::guard('api')->user()->id,$followers)){
            return response()->json(['followed'=>true]);
        }
        return response()->json(['followed'=>false]);
    }

    public function follow()
    {

        $userToFollow=User::find(request('user'));
        $followed=Auth::guard('api')->user()->followThisUser($userToFollow->id);
        if ($followed['attached']!=[]){
            $userToFollow->notify(new NewUserNotification());
            $userToFollow->increment('followers_count');

            return response()->json(['followed'=>true]);
        }
        $userToFollow->decrement('followers_count');

        return response()->json(['followed'=>false]);
    }
}
