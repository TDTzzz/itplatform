<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class NotificationController extends Controller
{
    public function index()
    {
        $user=\Auth::user();
        return view('notification.show',compact('user'));
    }
}
