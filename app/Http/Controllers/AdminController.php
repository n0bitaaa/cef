<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use Session;
use Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = Admin::paginate(10);
        return view('admin.index',compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    
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
            'name'=>'required|min:4'
        ]);
        $admin = Admin::findOrFail($id);
        $admin->name=$request->name;
        if($request->code){
            $admin->code = $request->code;
        }
        if($request->password){
            $request->validate([
                'password' => 'min:8',
                'n_password'=> 'required|min:8',
            ]);
            if(Hash::check($request->password,$admin->password)){
                $admin->password = bcrypt($request->n_password);
            }
        }
        $data = $admin->update();
        Session::flash('update','Updated Successfully!');
        return redirect()->route('admins.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();
        DB::statement("ALTER TABLE admins AUTO_INCREMENT = 1");
        Session::flash('delete','Deleted Successfully!');
        return redirect()->route('admins.index');
    }

    public function newCode(Request $request){
        $newCode = Str::uuid();
        return $newCode;
    }

    public function search(Request $request){
        $admins = Admin::where('name','LIKE','%'.$request->admin.'%')->paginate(10);
        return view('admin.index',compact('admins'));
    }
}
