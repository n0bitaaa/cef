<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use Auth;
use Session;
use App\Product;
use Carbon\Carbon;
use DB;
use App\User;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::orderBy('state')->orderBy('queue')->paginate(10);
        return view('order.index',compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('order.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'products' => 'required|array',
            'products.*'=>'required',
            'w_week'=>'required',
            'user_id'=>'required',
        ]);
        $products = $request->input('products',[]);
        $quantities = $request->input('quantities',[]);
        $remarks = $request->input('remarks',[]);
        $total = 0;
        for($product=0;$product<count($products);$product++){
            $productprice = Product::findOrFail($products[$product])->price;
            $quantity = $quantities[$product];
            $total += $productprice*$quantity;
        }
        $due_date = Carbon::now()->addWeeks($request->w_week);
        $queue = Order::where('state',0)->orderBy('queue','desc')->first()->queue;
        $order = Order::create([
            'totl_qty'=>array_sum($quantities),
            'totl_amt'=>$total,
            'state'=> 0,
            'due_date'=>$due_date,
            'w_week'=>$request->w_week,
            'queue'=>$queue+1,
            'user_id'=>$request->user_id,
            'admin_id'=>Auth::guard('admin')->user()->id,
        ]);
        for($product=0;$product<count($products);$product++){
            $productprice = Product::findOrFail($products[$product])->price;
            if($products[$product] != ''){
                $order->products()->attach($products[$product],['qty'=> $quantities[$product],'rmk'=>$remarks[$product],'price'=>$productprice]);
            }
        }
        Session::flash('success',"Created Successfully!");
        return redirect()->route('orders.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'products' => 'required|array',
            'products.*'=>'required',
            'w_week'=>'required',
        ]);
        $products = $request->input('products',[]);
        $quantities = $request->input('quantities',[]);
        $remarks = $request->input('remarks',[]);
        $total = 0;
        for($product=0;$product<count($products);$product++){
            $productprice = Product::findOrFail($products[$product])->price;
            $quantity = $quantities[$product];
            $total += $productprice*$quantity;
        }
        $due_date = Carbon::now()->addWeeks($request->w_week);
        $final_queue = Order::where('state',0)->orderBy('queue','desc')->first()->queue;
        $order = Order::findOrFail($id);
        $order->totl_qty = array_sum($quantities);
        $order->totl_amt = $total;
        $order->state = 0;
        $order->due_date = $due_date;
        $order->w_week = $request->w_week;
        $order->queue = $final_queue+1;
        $order->admin_id = Auth::guard('admin')->user()->id;
        $order->update();
        $order->products()->newPivotStatement()->where('order_id',$id)->delete();
        for($product=0;$product<count($products);$product++){
            $productprice = Product::findOrFail($products[$product])->price;
            if($products[$product] != ''){
                $order->products()->attach($products[$product],['qty'=> $quantities[$product],'rmk'=>$remarks[$product],'price'=>$productprice]);
            }
        }
        Session::flash('update',"Updated order($id) Successfully!");
        return redirect()->route('orders.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->products()->newPivotStatement()->where('order_id',$id)->delete();
        $order->delete();
        DB::statement("ALTER TABLE orders AUTO_INCREMENT = 1");
        Session::flash('delete',"Deleted Successfully!");
        return redirect()->route('orders.index');
    }

    public function orderComplete($id){
        Order::where('id',$id)->update(['state'=>1]);
        Session::flash('complete',"Finshed Order($id) Successfully!");
        return redirect()->route('orders.index');
    }

    public function search(Request $request){
        $users = User::where('name','LIKE','%'.$request->order.'%')->get();
        $orders = Order::where('user_id','brhtaeyamllmthibu')->paginate(10);
        if($users){
            foreach($users as $user){
                $orders = Order::where('user_id','LIKE','%'.$user->id.'%')->paginate(10);
            }
        }
        return view('order.search',compact('orders'));
    }
}
