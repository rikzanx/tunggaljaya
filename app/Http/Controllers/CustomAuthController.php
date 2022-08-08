<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;

class CustomAuthController extends Controller
{

    public function index()
    {
        $company = Company::first();
        return view('login',[
            "company" => $company
        ]);
    }  
      

    public function customLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        // dd('oke');
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // dd($credentials);
            return redirect()->route('admin.dashboard')
                        ->with('status', 'Signed in');
        }
        return redirect()->route("login")->with('danger','Login details are not valid');
    }



    public function registration()
    {
        return view('auth.registration');
    }
      

    public function customRegistration(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
           
        $data = $request->all();
        $check = $this->create($data);
         
        return redirect()->route("admin.dashboard")->with('status', 'You have signed-in');
    }


    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);
    }    
    

    public function dashboard()
    {
        if(Auth::check()){
            return view('dashboard');
        }
  
        return redirect()->route('login')->with('danger', 'You are not allowed to access');
    }
    

    public function signOut() {
        Session::flush();
        Auth::logout();
  
        return redirect()->route('login')->with('danger', 'Success Logout');
    }
}