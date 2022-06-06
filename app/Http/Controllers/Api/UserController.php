<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $successCode = 200;
    public function register(Request $request){
            // validate data
            $this->validate($request,[
                 'name' => 'required',
                 'email' => 'required|unique:users|email',
                 'mobile' => 'required',
                 'password' => 'required|confirmed',
            ]);

            // create new user
            $user = [
                 'name' => $request->name,
                 'email' => $request->email,
                 'mobile' => $request->mobile,
                 'password' => bcrypt($request->password),
            ];
        try{
             User::create($user);
             $message['message'] = 'Registration successful';
             return response()->json(['success' => $message], $this->successCode);
        }catch(Exception $e){
              $message['message'] = $e->getMessage();
              return response()->json(['success' => $message], $this->getCode());
        }
    }
}
