<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $token = $request->bearerToken();

        $user = User::where('api_token', $token)->first();
        if (!$user) {
            return response()->json(['success'=>false, 'message' => 'Authentication error'],404);
        }
        if($user->is_admin){
            return User::all();
        }
        return response()->json(['success'=>false, 'message' => 'Permission denied'],403);
    }

    public function findUser(Request $request, $name)
    {
        

        $token = $request->bearerToken();

        $user = User::where('api_token', $token)->first();
        if (!$user) {
            return response()->json(['success'=>false, 'message' => 'Authentication error'],404);
        }
        if($user->is_admin){

            $found_user = User::where('name','regexp',"$name")->get();
            return response()->json($found_user, 200); 
        }
        return response()->json(['success'=>false, 'message' => 'Permission denied'],403);
    }

    public function show(Request $request)
    {
        $token = $request->bearerToken();

        $user = User::where('api_token', $token)->first();

        if (!$user) {
            return response()->json(['success'=>false, 'message' => 'Authentication error'],404);
        }
        return response()->json($user, 201); 
        
    }

    

    // public function store(Request $request)
    // {
    //     $article = Article::create($request->all());

    //     return response()->json($article, 201);
    // }

    // public function update(Request $request, Article $article)
    // {
    //     $article->update($request->all());

    //     return response()->json($article, 200);
    // }

    // public function delete(Article $article)
    // {
    //     $article->delete();

    //     return response()->json(null, 204);
    // }
}
