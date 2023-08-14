<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(Request $request)
    {

        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required|confirmed",
        ]);


        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);


        $user->save();
        // Auth::login($user);




        return response()->json([
            "status" => true,
            // "access_token" =>  $user()->createToken("auth_token")->accessToken,
        ]);
    }


    public function login(Request $request)
    {

        $login_data = $request->validate([
            "email" => "required",
            "password" => "required"
        ]);

        if(!auth()->attempt($login_data)){

            return response()->json([
                "status" => false,
                "message" => "Invalid Credentials"
            ]);
        }


        $token = auth()->user()->createToken("auth_token")->accessToken;


        return response()->json([
            "status" => true,
            "access_token" => $token
        ]);
    }

    // public function registerIt(){
    //     return view('register');
    // }
    // public function loginIt(){
    //     return view('login');
    // }

    public function logout(Request $request)
    {

        $token = $request->user()->token();


        $token->revoke();

        return response()->json([
            "status" => true,
            "message" => " logged out "
        ]);
    }
}
