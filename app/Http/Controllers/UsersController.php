<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function notifications() {
        // auth()->user()->unreadNotifications;
        // auth()->user()->readNotifications;

        auth()->user()->unreadNotifications->markAsRead();

        $notifications = auth()->user()->notifications()->paginate(10);
        return view('users.notifications', \compact([
            'notifications'
        ]));
    }
}
