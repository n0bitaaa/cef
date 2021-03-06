<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Cookie;
use PDF;

class FrontendController extends Controller
{
    public function index(){
        Alert::success('<h5>Login Successfully!</h5>', '<p class="small text-muted" style="font-family: "Inter", sans-serif;">"You are welcome to CEFverse"</p>')->toHtml();
        $orders = Order::where('user_id',Auth::user()->id)->get();
        return view('frontend.index',compact('orders'));
    }

    public function receipt(){
        $orders = Order::where('user_id',Auth::user()->id)->get();
        $pdf = PDF::loadView('frontend.receipt',compact('orders'));
        return $pdf->download('receipt.pdf');
    }
}
