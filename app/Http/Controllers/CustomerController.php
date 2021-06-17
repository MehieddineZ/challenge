<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function user(){
        return 'Authenticated User';
    }
    public function create_customer(Request $request){
        return Customer::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' =>Hash::make( $request->input('password'))
        ]);
    }
    public function login_customer(Request $request){
      if (!Auth::attempt($request->only('email','password'))){
          return response([
              'message' => 'Invalid credentials'
          ],Response::HTTP_UNAUTHORIZED);
    }
    $customer = Auth::user();

    return $customer;
}
public function get_customers()
{
    $customer = Customer::all()->toArray();
    return $customer;
}
}
