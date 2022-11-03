<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
     //Creación de posts
     public function createComment(Request $request)
     {
         //JSON invalido? error 400
         json_decode($request->getContent());
         if (json_last_error() != JSON_ERROR_NONE) {
            return response()->noContent(400);
         }
         
         $rules = [
             'content' => 'required',
             'user_id'    => 'required',
             'post_id'    => 'required',
         ];
         $input     = $request->only('content', 'user_id','post_id');
         $validator = Validator::make($input, $rules);
 
         if ($validator->fails()) {
             return response()->json(['error' => $validator->messages()], 400);
         }


         $content =$request->content;
         $reported = $request->reported;
         $user_id = $request->user_id;
         $reported_by = $request->reported_by;
         $post_id = $request->post_id;

         $post = Post::find($post_id);
         if (!$post)
            return response()->noContent(404);
        $user = User::find($user_id);
        if (!$user)
            return response()->noContent(404);
 
         $comment     = Comment::create(
             ['content' => $content, 
             'reported' => $reported,
             'user_id' => $user_id,
             'reported_by' => $reported_by,
             'post_id' => $post_id]
         );
         return response()->noContent(Response::HTTP_CREATED);
     }
     public function updateComment($id, Request $request)
     {
        $comment = Comment::find($id);
        if (!$comment)
            return response()->noContent(404);
        
         //JSON invalido? error 400
         json_decode($request->getContent());
         if (json_last_error() != JSON_ERROR_NONE) {
            return response()->noContent(400);
         }
         
         $rules = [
             'content' => 'required',
         ];
         $input     = $request->only('content');
         $validator = Validator::make($input, $rules);
 
         if ($validator->fails()) {
             return response()->json(['error' => $validator->messages()], 400);
         }

         $comment->content =$request->content;
         $comment->reported = $request->reported;
         $comment->reported_by = $request->reported_by;
 
         $comment->save();
         return response()->noContent(204);
     }
     public function deleteComment($id){
    
        $comment = Comment::find($id);
        if (!$comment)
            return response()->noContent(404);
        
        //borrar 
        //Likes tb? 
        $comment->delete();
        
        return response()->noContent(204);
    }
    public function getComment($id){
        $comment = Comment::find($id);
        if (!$comment)
            return response()->noContent(404);
        return response()->noContent(Response::HTTP_CREATED);
    }
    public function postComments($id, Request $request){

        $post = Post::find($id);
        if (!$post)
            return response()->noContent(404);

        $comments = Comment::where('post_id',$id)->get();

        return response()->json($comments);
    }
    public function comments(Request $request){

        if ($request->has('reported'))
            $comments = Comment::where('reported',true)->get();
        else{
            $comments = Comment::all();
        }

        return response()->json($comments);
    }


}
