<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AdminLoginVerifyRequest;
use App\Http\Requests\UserLoginVerifyRequest;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;


class loginController extends Controller
{
    
    public function adminIndex()
    {
    	return view('admin_panel.adminLogin');
    }
    public function adminLogout()
    {
        session()->flush();   
    	return redirect()->route('admin.login');
    }
    public function adminPosted(AdminLoginVerifyRequest $request)
    {  
        $admin = Admin::where('username',$request->Username)->first();
        
        if($admin==null)
        {
            
            $request->session()->flash('message', 'Invalid Username');
            
            return redirect(route('admin.login'));
        }
        
        else
        {
            if($request->Password==$admin->password)
            {
                session()->put('admin',$admin);
                //$request->session()->put('username', $request->Username);
                return redirect()->route('admin.dashboard');
            }
            
            else if($request->Password!=$admin->password)
            {
                $request->session()->flash('message', 'Invalid Password');
                return view('admin_panel.adminLogin');
            }
        }
        
        
        
    }
    
    
    public function userIndex()
    {
        // session()->flush();
        if(session()->has('user')){
            // dd(session()->get('user'));
            return redirect()->route("user.cart");
        }

        $res = Product::all();
        $cat = Category::all();

        return view('store.login')
        ->with('products', $res)
        ->with("cat", $cat);

    }

    public function userPosted(UserLoginVerifyRequest $request)
    {

        
        // validate based on the rules 
        //dd(request()->all());
        // Auth::logout(Auth::user());
        // dd($user);
       // session()->flush();
         //dd("holde submission");
        $request_arr = [
            "email"=>$request->email,
            "password"=>$request->pass
        ];
        $validate = Validator::make(request()->all(), $request->rules());
        if($validate->fails())
        {
            // return response()->json()
            return back()->with("error","Error occurred, the combination of email and password ");
        }

    
         //auth log user in
        //get credentials
        $credentials = $request_arr;

        if(Auth::attempt($credentials))
        {
           return redirect()->route('user.home')->with("success","Successfully logged in");
        }
        else
        {
            return back()->with("error","Error occurred, the combination of email and password ");
        }


        // $user = Auth::attempt();

        // $user = User::where('email',$request->email)
        // ->where('password',$request->pass)
        // ->first();

        // if($user==null)
        // {
        //     $request->session()->flash('message', 'Invalid User');
    		
        //     return redirect()->route('user.login');
        // }
        // else
        // {
        //     $request->session()->put('user', $user);
        //     return redirect()->route('user.home');
        // }
    }
    public function userLogout(Request $r)
    {
        Auth::logout();
        return redirect()->route('user.home');
    }
}