<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use Auth;
use Session;
use App\Product;
use Carbon\Carbon;
use DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::paginate(10);
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
        $order = Order::create([
            'totl_qty'=>array_sum($quantities),
            'totl_amt'=>$total,
            'state'=> 0,
            'due_date'=>$due_date,
            'w_week'=>$request->w_week,
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
        //
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
        Session::flash('complete',"Finshed Successfully!");
        return redirect()->route('orders.index');
    }
}
