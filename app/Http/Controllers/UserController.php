<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('user.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
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
            'password'=>'required|min:4|confirmed',
            'phone'=>'required',
            'address'=>'required|min:5',
        ]);
        User::create([
            'name'=>$request->name,
            'password'=>bcrypt($request->password),
            'phone'=>$request->phone,
            'address'=>$request->address,
            'admin_id'=>Auth::guard('admin')->user()->id,
        ]);
        Session::flash('success','Created Successfully!');
        return redirect()->route('users.index');
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
            'name'=>'required|min:4',
            'phone'=>'required|min:5',
            'address'=>'required|min:5',
        ]);
        $user = User::findOrFail($id);
        $user->name = $request->name;
        if($request->c_pw){
            $request->validate([
                'c_pw'=>'min:8',
                'password'=>'required|min:8',
            ]);
            if(Hash::check($request->c_pw,$user->password)){
                $user->password = bcrypt($request->password);
            }
        }
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->admin_id = Auth::guard('admin')->user()->id;
        $user->update();
        Session::flash('update','Updated Successfully!');
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        DB::statement("ALTER TABLE users AUTO_INCREMENT = 1");
        Session::flash('delete',"Deleted Successfully!");
        return redirect()->route('users.index');
    }
}
