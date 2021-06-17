<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class AuthenticationController extends Controller
{
    public function user(){
        return 'Authenticated User';
    }
    public function register(Request $request){
        return User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' =>Hash::make( $request->input('password'))
        ]);
    }
    public function login(Request $request){
      if (!Auth::attempt($request->only('email','password'))){
          return response([
              'message' => 'Invalid credentials'
          ],Response::HTTP_UNAUTHORIZED);
    }
    $user = Auth::user();

    return $user;
}
public function getUsers()
{
    $user = User::all()->toArray();
    return $user;
}
}
