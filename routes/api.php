<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
*/
//RUTAS DE USUSARIO
//Usuarios registrados
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user(); });
Route::middleware('auth:sanctum')->put('/user', [UserController::class,'updateUser']);
//Sin registrarse
Route::get('/users',[UserController::class,'users']);
Route::post('/login',[UserController::class,'login']);
Route::post('/register',[UserController::class,'register']);
Route::get('/user/{id}',[UserController::class,'getUser']);

//RUTAS DE IMAGENES
//Usuarios registrados
Route::middleware('auth:sanctum')->post('/image', [ImageController::class,'uploadImage']);
//Sin registrarse
Route::get('/image/{id}',[ImageController::class,'getImage']);

//RUTAS DE POSTS
//Usuarios regitrados
Route::middleware('auth:sanctum')->post('/post', [PostController::class,'createPost']);
Route::middleware('auth:sanctum')->put('/post/{id}', [PostController::class,'updatePost']);
Route::middleware('auth:sanctum')->delete('/post/{id}', [PostController::class,'deletePost']);
//Sin registrarse
Route::get('/post/{id}',[PostController::class,'getPost']);
Route::get('/post',[PostController::class,'posts']);

//RUTAS DE COMENTARIOS
//Usuarios regitrados
Route::middleware('auth:sanctum')->post('/comment', [CommentController::class,'createComment']);
Route::middleware('auth:sanctum')->put('/comment/{id}', [CommentController::class,'updateComment']);
Route::middleware('auth:sanctum')->delete('/comment/{id}', [CommentController::class,'deleteComment']);
//Sin registrarse
Route::get('/comment/{id}',[CommentController::class,'getComment']);
Route::get('/comment',[CommentController::class,'comments']);
Route::get('/comments/{id}',[CommentController::class,'postComments']);

//RUTAS DE LIKES
//Usuarios regitrados
Route::middleware('auth:sanctum')->post('/like', [LikeController::class,'createLike']);
Route::middleware('auth:sanctum')->delete('/like/{id}', [LikeController::class,'deleteLike']);
//Sin registrarse
Route::get('/like/{id}',[LikeController::class,'getLike']);
Route::get('/like',[LikeController::class,'likes']);
Route::get('/likes/{id}',[LikeController::class,'postLikes']);

