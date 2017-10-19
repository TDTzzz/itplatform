<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;


class NotificationController extends Controller
{
    public function index()
    {
        $user=\Auth::user();
        return view('notification.show',compact('user'));
    }

    public function show(DatabaseNotification $notification)
    {
//        dd($notification);
        $notification->markAsRead();
        return redirect(\Request::query('redirect_url'));
    }
}
