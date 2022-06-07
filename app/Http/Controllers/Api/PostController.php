<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    // post list
    public function index(){
             $user_id = Auth::id();
             $is_exists = Post::where('user_id', $user_id)->exists();
             if(!$is_exists){
                  $message['message'] = 'Data not found!';
                  return response()->json([
                        'message' => $message,
                  ], 404);
             }

            $posts = Post::whereIn('user_id', [$user_id])->get();

            $message['message'] = 'Great! Data found.';
          return response()->json([
                'message' =>  $message,
                'posts' => $posts
          ], 200);
    }

    // store post
    public function store(Request $request){
               $this->validate($request, [
                     'title' => 'required|string',
                     'description' => 'required',
               ]);

             $input = $request->all();
             $input['user_id'] = Auth::id();
         try{
              Post::create($input);
              $message['message'] = 'Post created successfully';
              return response()->json(['message' => $message], 200);
         }catch(Exception $e){
            $message['message'] = $e->getMessage();
            return response()->json(['message' => $message], $e->getCode());
         }
    }

    // update post
    public function update(Request $request, $id){
               $this->validate($request, [
                     'title' => 'required|string',
                     'description' => 'required',
               ]);
             
               $post = Post::findOrFail($id);

         try{
             $post->update($request->all());
              $message['message'] = 'Post updated successfully';
              return response()->json(['message' => $message], 200);
         }catch(Exception $e){
            $message['message'] = $e->getMessage();
            return response()->json(['message' => $message], $e->getCode());
         }
    }

    // delete post
    public function destroy($id){
        $post = Post::findOrFail($id);
        try{
            $post->delete();
             $message['message'] = 'Post deleted successfully';
             return response()->json(['message' => $message], 200);
        }catch(Exception $e){
           $message['message'] = $e->getMessage();
           return response()->json(['message' => $message], $e->getCode());
        }
    }
}
