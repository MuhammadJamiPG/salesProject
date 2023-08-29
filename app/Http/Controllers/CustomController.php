<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Session;

class CustomController extends Controller
{
    public function __construct(){
        $this->user = new User();
    }
    public function assignSP(){
        $salesHead = $this->user->where('role', $this->user::SalesHead)->get();

        return view('assign-sp', compact('salesHead'));
    }
    public function assignedSP(Request $request){  
        $request->validate([
           'name'          => 'required',
           'email'         => 'required|email|unique:users',
           'password'      => 'required|min:6',
           'sales_head_id' => ['required','numeric',Rule::exists('users', 'id')->where('role', User::SalesHead)],
       ],
       [
        'sales_head_id.required' => 'Sales Head is required',
        'name.required' => 'SP Name is required',
        'email.required' => 'SP Email is required',
        'password.required' => 'SP Password is required',
        'password.min' => 'SP Password must be at least 6 characters.',
       ]
       );
       $sales_person = $this->user->create([
            'name'     => $request->name,
            'email'    => $request->email, 
            'password' => Hash::make($request->password),
            'role'     => $this->user::SalesPerson,
            'lead_id'  => $request->sales_head_id
       ]);
       return redirect()->back()->withSuccess('Sales person has been created successfully, sales head is assigned');
    }
    public function refrence($sp_id){
      $findSP  = $this->user->where('role', $this->user::SalesPerson)->where('id', $sp_id)->whereNotNull('lead_id')->first();

      if(is_null($findSP)){
        return redirect()->route('assign-sp')->withError('No sales person for refrence signup');
      }

      return view('refrence-signup', compact('sp_id'));
    }
    public function signup(Request $request, $sp_id){  
        $request->validate([
           'name'          => 'required',
           'email'         => 'required|email|unique:users',
           'password'      => 'required|min:6'
       ],
       [
        'name.required' => 'Customer Name is required',
        'email.required' => 'Customer Email is required',
        'password.required' => 'Customer Password is required',
        'password.min' => 'Customer Password must be at least 6 characters.',
       ]
       );
       $customer = $this->user->create([
            'name'     => $request->name,
            'email'    => $request->email, 
            'password' => Hash::make($request->password),
            'role'     => $this->user::Customer,
            'lead_id'  => $sp_id
       ]);

       $sp = $this->user->where('id', $sp_id)->first();
       $sh = $this->user->where('id', $sp->lead_id)->first();

        if(!is_null($sp)){
            $sp->update(['credit' => is_null($sp->credit) ? 0+5 : $sp->credit + 5 ]);
        }
        if(!is_null($sh)){
            $sh->update(['credit' => is_null($sh->credit) ? 0+5 : $sh->credit + 5 ]);
        }

       return redirect()->back()->withSuccess('Customer has been created successfully, sales person and his lead credited successfully');
    }
    public function login(){
        return view('login');
    }
    public function postLogin(Request $request){
       $request->validate([
           'email' => 'required',
           'password' => 'required',
       ]);
  
       $credentials = $request->only('email', 'password');
       if (Auth::attempt($credentials)) {
            if(auth()->user()->role == $this->user::SalesHead || auth()->user()->role == $this->user::SalesPerson){ 
               return redirect()->intended('dashboard')
                           ->withSuccess('You have Successfully loggedin');
            }else{
                Session::flush();
                Auth::logout();
              
                return Redirect('login')->withError('Invalid role for login');
            }
       }
 
       return redirect("login")->withSuccess('Invalid credentials');
    }
    public function dashboard(){
        if(Auth::check()){
            return view('dashboard');
        }
      
        return redirect("login")->withError('Opps! You do not have access');
    }
    public function logout(){
       Session::flush();
       Auth::logout();
 
       return Redirect('login');
    }
    public function seeYourSps($sh_id){
        if(auth()->id() == $sh_id){

            $sps = $this->user->where('lead_id', $sh_id)->get();
            return view('see-sales-persons', compact('sps'));
        }else{
            return redirect('dashboard')->withError('Invalid attempt!');
        }
    }
}
