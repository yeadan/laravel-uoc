<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Image;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    //Devuelve todos los posts, si se pone la opcion de public, solo devuelve los publicos.
    // Añadida la opcion de que solo se devuelvan los post reportados, para los moderadores
    public function posts(Request $request){

        if($request->has('public')){
            $posts = Post::where('public',true)->get();
        }else if ($request->has('reported'))
            $posts = Post::where('reported',true)->get();
        else{
            $posts = Post::all();
        }

        //Facilitar las busquedas
        foreach ($posts as $post)
            $post->all = $this->getPost($post->id)->original;

        return response()->json($posts);
    }

    //Creación de posts
    public function createPost(Request $request)
    {
        //JSON invalido? error 400
        json_decode($request->getContent());
        if (json_last_error() != JSON_ERROR_NONE) {
            return response()->noContent(400);
        }
        
        $rules = [
            'title' => 'required',
            'user_id'    => 'required',
        ];
        $input     = $request->only('title', 'user_id');
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()],400);
        }
        $title = $request->title;
        $description =$request->description;
        $public = $request->public;
        $reported = $request->reported;
        $num_likes = $request->num_likes;
        $user_id = $request->user_id;
        $reported_by = $request->reported_by;
        $image_id = $request->image_id;

        $user = User::find($user_id);
        if (!$user)
            return response()->noContent(404);
        $image = Image::find($image_id);
        if (!$image)
            return response()->noContent(404);   

        $post     = Post::create(
            ['title' => $title, 
            'description' => $description, 
            'public' => $public,
            'reported' => $reported,
            'num_likes' => $num_likes,
            'user_id' => $user_id,
            'reported_by' => $reported_by,
            'image_id' => $image_id]
        );

    //Devolvemos Image y User para facilitar las búsquedas
    return response()->json(['data' => $post,'user' => $user,'image' => $image]);

        return response()->json(['data' => $post, 'user' => $user], Response::HTTP_CREATED);
    }
    public function getPost($id){
        $post = Post::find($id);
        if (!$post)
            return response()->noContent(404);
            
        $user = User::find($post->user_id);
        if (!$user)
            return response()->noContent(404);
        $image = Image::find($post->image_id);
        if (!$image)
            return response()->noContent(404);   
        //Devolvemos Image y User para facilitar las búsquedas
        return response()->json(['data' => $post,'user' => $user,'image' => $image]);

    }
    //Modificar post. No se puede moficiar usuario ni imagen 
    public function updatePost($id, Request $request){
    
        $post = Post::find($id);
        if (!$post)
            return response()->noContent(404);
        
        //JSON invalido? error 400
        json_decode($request->getContent());
        if (json_last_error() != JSON_ERROR_NONE) {
            return response()->noContent(400);
        }

        $rules = [
            'title' => 'required',
        ];

        $input     = $request->only('title');
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        $post->title = $request->title;
        $post->description =$request->description;
        $post->public = $request->public;
        $post->reported = $request->reported;
        $post->num_likes = $request->num_likes;
        $post->reported_by = $request->reported_by;

        $post->save();
        
        return response()->noContent(204);
    }
    public function deletePost($id){
    
        $post = Post::find($id);
        if (!$post)
            return response()->noContent(404);
        
        //borrar comentarios?
        //Comment:whereIn('post_id',$post)->delete()
        //Likes tb? imagenes?
        $post->delete();
        
        return response()->noContent(204);
    }

}
