<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class LikeController extends Controller
{
    //Creación de likes
    public function createLike(Request $request)
    {
        //JSON invalido? error 400
        json_decode($request->getContent());
        if (json_last_error() != JSON_ERROR_NONE) {
            return response()->noContent(400);
        }
        
        $rules = [
            'user_id'    => 'required',
            'post_id'    => 'required',
        ];
        $input     = $request->only('user_id','post_id');
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        $user_id = $request->user_id;
        $post_id = $request->post_id;

        $post = Post::find($post_id);
        if (!$post)
            return response()->noContent(404);
        $user = User::find($user_id);
        if (!$user)
            return response()->noContent(404);
        
        //Comprobar que no exista ya ese like (mismo user_id y post_id)
        $mylike = Like::where('user_id',$user_id)->where('post_id',$post_id)->first();
        if ($mylike)
            return response()->noContent(400); 

        $likes    = Like::create(
            ['user_id' => $user_id,
            'post_id' => $post_id]
        );
        //Sumamos un num_like al post
        $post->num_likes += 1;
        $post->save();

        return response()->noContent(Response::HTTP_CREATED);
    }
    
    public function deleteLike($id){

        $likes = Like::find($id);
        if (!$likes)
            return response()->noContent(404);
        
        //Borramos el num_like
        $post = Post::Find($likes->post_id);
        if (!$post)
            return response()->noContent(404);
        $post->num_likes -= 1;
        $post->save();

        $likes->delete();   
        return response()->noContent(204);
    }

    public function getLike($id){
        $likes = Like::find($id);
        if (!$likes)
            return response()->noContent(404);
        return response()->json(['data' => $likes]);
    }

    public function postLikes($id){

        $post = Post::find($id);
        if (!$post)
            return response()->noContent(404);

        $likes = Like::where('post_id',$id)->get();

        return response()->json($likes);
    }

    public function likes(Request $request){

        $likes = Like::all();
        return response()->json($likes);
    }
}

