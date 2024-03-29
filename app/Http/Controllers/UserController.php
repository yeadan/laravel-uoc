<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function register(Request $request)
    {
        //JSON invalido? error 400
        json_decode($request->getContent());
        if (json_last_error() != JSON_ERROR_NONE) {
            return response()->noContent(400);
        }

        $rules = [
            'name' => 'unique:users|required',
            'email'    => 'unique:users|required',
            'password' => 'required',
        ];
        $input     = $request->only('name', 'email','password');
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json(['error' => 'El usuario ya existe'], 400);
        }
        $name = $request->name;
        $email    = $request->email;
        $password = $request->password;
        $user     = User::create(['name' => $name, 'email' => $email, 'password' => Hash::make($password)]);
        return response()->noContent(Response::HTTP_CREATED);
    }
    public function getUser($id){
        $user = User::find($id);
        if (!$user)
            return response()->noContent(404);
        return response()->json(['data' => $user]);
    }
    public function users(Request $request){

        if($request->has('active')){
            $users = User::where('active',true)->get();
        }else{
            $users = User::all();
        }

        return response()->json($users);
    }

    public function login(Request $request){

        $response = ["msg"=>""];
        $data = json_decode($request->getContent());
        //JSON invalido? error 400
        if (json_last_error() != JSON_ERROR_NONE) {
            return response()->noContent(400);
        }
        $user = User::where('email',$data->email)->first();

        if($user){
            if(Hash::check($data->password,$user->password)){
                $token = $user->createToken("example");
                $response["msg"] = $token->plainTextToken;
                $response["user"] = $user;

            }else{
                return response()->json(['error' => 'Credenciales erróneas'], 401); 
            }
        }else{
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }
        return response()->json(['data' => $response]);      
    }

    //Modificar los datos de usuario
    public function updateUser($id, Request $request){
        
        //JSON invalido? error 400
        json_decode($request->getContent());
        if (json_last_error() != JSON_ERROR_NONE) {
            return response()->noContent(400);
        }

        $user = User::find($id);
        if (!$user)
            return response()->noContent(404);
        //Puede cambiar nombre, email y password
        $rules = [
            'email'    => 'unique:users'
        ];

        $input     = $request->only('email');
        $validator = Validator::make($input, $rules);

        if ($validator->fails() && $request->email != $user->email) {
            return response()->json([ 'error' => 'Este email ya está en uso'], 400);
        }

        $user->email = $request->email;
        $user->name = $request->name;
        if ($request->password)
            $user->password = Hash::make($request->password);
        $user->save();
        
        return response()->noContent(204);
    }

}
