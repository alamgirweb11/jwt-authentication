<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $successCode = 200;
    // register user
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
             return response()->json(['success' => $message], 201);
        }catch(Exception $e){
              $message['message'] = $e->getMessage();
              return response()->json(['success' => $message], $this->getCode());
        }
    }

    // login user
    public function login(Request $request){
         $this->validate($request, [
              'email' => 'required|email',
              'password' => 'required'
         ]);

         if(!$token = auth()->attempt(['email' => $request->email, 'password' => $request->password])){
                $message['message'] = 'The given credentials is incorrect!';
                return response()->json(['error' => $message], 422);
         }
         $message['message'] = 'Successfully Login';
         return response()->json([
              'message' => $message,
              'token' => $token,
         ], $this->successCode);
    }

    // get user profile
    public function profile(){
         $user = Auth::user();
         if($user){
             $message['message'] = $user->name."'s".' Profile';
            return response()->json([
                'success' => $message,
                'data' => $user,
            ], $this->successCode);
         }else{
            $message['message'] = 'You have to login first.';
            return response()->json([
                'error' => $message,
            ], 401);
         }
    }

    // logout
    public function logout(){
          Auth::logout();
          $message['message'] = 'You are logged out.';
          return response()->json([
                  'message' => $message,
          ], $this->successCode);
    }
}
