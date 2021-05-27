<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use Auth;
use Session;

class NotificationController extends Controller
{
    public function index(){
        return view('notification.index');
    }

    public function readOne($id){
        Admin::findOrFail(Auth::guard('admin')->user()->id)->unreadNotifications()->where('id',$id)->update(['read_at' => now()]);
        Session::flash('readOne',"Read Successfully!");
        return redirect()->route('noti_index');
    }

    public function readAll(){
        Admin::findOrFail(Auth::guard('admin')->user()->id)->unreadNotifications->markAsRead();
        Session::flash('readAll',"Read All Successfully!");
        return redirect()->route('noti_index');
    }
}
