<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;


class AdminController extends Controller
{

    public function index(){
        return view("login");
    }
    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return back()->with('error', 'Validation error');
            // return response()->json($validator->messages(), 400);
        }

        // Retrieve username and password from the request
        $username = $request->username;
        $password = $request->password;

        // Check if an admin with the given username exists
        $admin = Admin::where("username", $username)->first();

        // If admin is found and password matches
        if($admin && Hash::check($password, $admin->password)) {
            $request->session()->put('id', $admin->id); // a way of temporarily storing and making data accessible across all the website pages
            $request->session()->put('admin', $admin->username);
            return redirect()->route('home')->with('success', 'Admin Login Successfully');
        } else {
            return back()->with('error', 'Password not match');
        }
    }

    public function logout()
    {
        if (Session::has('admin')) {
            Session::pull('admin');
            return redirect()->route('login')->with('success', 'Logout successful');
        }
    }

}
