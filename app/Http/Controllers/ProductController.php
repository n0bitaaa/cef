<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Auth;
use Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(10);
        return view('product.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.create');
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
            'name'=>'required',
            'image'=>'required|mimes:jpeg,png,jpg|max:6120',
            'price'=>'required|integer',
        ]);
        $file = $request->image;
        $extension = $file->extension();
        $uuid = Str::uuid();
        $request->image->storeAs('/public',$uuid.".".$extension);
        $url = Storage::url($uuid.".".$extension);
        Product::create([
            'name'=>ucwords($request->name),
            'image'=>$url,
            'price'=>$request->price,
            'admin_id'=>Auth::guard('admin')->user()->id,
        ]);
        Session::flash('success','Created Successfully!');
        return redirect()->route('products.index');


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
            'name'=>'required',
            'price'=>'required',
        ]);
        $product = Product::findOrFail($id);
        $product->name = ucwords($request->name);
        $product->price = $request->price;
        if($request->image){
            $request->validate([
                'image'=>'mimes:jpeg,jpg,png|max:6120'
            ]);
            $file = $request->image;
            $extension = $file->extension();
            $uuid = Str::uuid();
            $request->image->storeAs('/public',$uuid.".".$extension);
            $url = Storage::url($uuid.".".$extension);
            $product->image = $url;
        }
        $product->update();
        Session::flash('update',"Updated Successfully!");
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        DB::statement("ALTER TABLE products AUTO_INCREMENT = 1");
        Session::flash('delete',"Deleted Successfully!");
        return redirect()->route('products.index');
    }

    public function search(Request $request){
        $products = Product::where('name','LIKE','%'.$request->product.'%')
                    ->orWhere('price','LIKE','%'.$request->product.'%')
                    ->paginate(10);
        return view('product.index',compact('products'));
    }
}
