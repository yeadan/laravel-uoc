<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Image;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;


class ImageController extends Controller
{

public function getImage($id){
    $image = Image::find($id);
    if (!$image)
        return response()->noContent(404);
    return response()->json(['data' => $image]);
}
public function uploadImage(Request $request){
    if (!$request->file('image'))
        return response()->json(['error' => 'No se ha encontrado la imagen']);
    //Carga la imagen en public/image
    $src = $request->file('image')->store('image','images');
    //Quitamos image/
    $src2 = explode('/',$src)[1];
    //Crea la imagen
    if (!$request->user())
        return response()->json(['error' => 'Usuario no encontrado']);
    $image = Image::create(['src' => $src2, 'user_id' => $request->user()->id]);
    if (!$image)
        return response()->noContent(404);
    return response()->json(['image' => $image, 'user'=> $request->user()],Response::HTTP_CREATED);
}
}
