<?php

namespace App\Http\Controllers;
use Hash;
use Illuminate\Http\Request;
use App\Admin;
use Illuminate\Support\Facades\Auth;
use Redirect;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function login(Request $request){
    	$dataAdmin = Admin::where('username',$request->username)->first();
        $admins['admins'] = Admin::where('username',$request->username)->first();
    	if($dataAdmin != NULL){
            if(Hash::check($request->password, $dataAdmin->password)){
                //Login Admin Success
                Auth::guard('admin')->LoginUsingId($dataAdmin->id);
                return view('admin.home', $admins);
            }else{
                return redirect('/adminLogin')->with('alert', 'Username atau Password salah');
            }
        }else{
        	return redirect('/adminLogin')->with('alert', 'Login Gagal tidak Berhasil');
        }
    }

    public function logout(Request $request){
        Auth::guard('admin')->logout();
        return view('admin.login');
    }

    public function register(Request $request){
    	$messages = [
            'required' => ':attribute Wajib Diisi',
            'max' => ':attribute Harus Diisi maksimal :max karakter',
            'min' => ':attribute Harus Diisi minimum :min karakter',
            'string' => ':attribute Hanya Diisi Huruf dan Angka',
            'confirmed' => ':attribute Konfirmasi Password Salah',
            'unique' => ':attribute Username sudah ada',
        ];

        $this->validate($request,[
            'username' => 'required|unique:admins|max:100',
            'name' => 'required|max:100',
            'phone' => 'required|max:13',
            'password' => 'required|min:8|string|confirmed'
        ],$messages);

    	$admin = new Admin;
    	$admin->username = $request->username;
    	$admin->name = $request->name;
    	$admin->profile_image = 'image/profile default.jpg';
    	$admin->phone = $request->phone;
    	$admin->password = Hash::make($request->password);
    	$admin->save();

    	return redirect('/adminLogin');
    }

}
