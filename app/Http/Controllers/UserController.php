<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class UserController extends Controller
{
    public function avatar()
    {
        return view('user.avatar');
    }

    public function changeAvatar(Request $request)
     {

         $file = $request->file('img');

         $filename = md5(time().Auth::user()->id).'.'.$file->getClientOriginalExtension();
         $file->move(public_path('avatars'), $filename);

         Auth::user()->avatar =$filename;
         Auth::user()->save();
         return ['url' => Auth::user()->avatar];
     }

    public function user()
    {
        $user=User::find(request('id'));
        $answers=$user->answers->unique('question_id');
        $nav='0';
        return view('user.answer',compact('user','nav','answers'));
     }

    public function question()
    {
        $user=User::find(request('id'));
        $nav='1';
        return view('user.question',compact('nav','user'));
     }

    public function followQuestion()
    {
        $user=User::find(request('id'));
        $followQuestion=$user->follows;
        $nav='2';
        return view('user.followQuestion',compact('nav','user','followQuestion'));
     }

    public function followUser()
    {
        $user=User::find(request('id'));
        $followers=$user->followers;
        $nav='3';
        return view('user.followers',compact('nav','user','followers'));
    }

    public function post()
    {
        $user=User::find(request('id'));
        $nav='4';
        return view('user.post',compact('nav','user'));
    }

    public function followPost()
    {
        $user=User::find(request('id'));
        $followPost=$user->postFollows;
        $nav='5';
        return view('user.followPost',compact('nav','user','followPost'));
    }

    public function followed()
    {
        $user=User::find(request('id'));
        $followersUser=$user->followersUser;
        $nav='';
        return view('user.followed',compact('nav','user','followersUser'));
    }
}
