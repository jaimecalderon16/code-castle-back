<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //obtener todos los comentarios de la app
    public function index($id){

        $comments=Comment::Where('app_id', $id)->with(['user'])->get();
        return response()->json(['comments' => $comments]);
    }

    //crear comentario
    public function store(Request $request){
        try{    
            $comment_date = Carbon::now();

            $request->validate([
            'comment'=>'required|string',
            'user_id'=>'required|exists:users,id',
            'app_id'=>'required|exists:apps,id',
        ]);
        $comment=Comment::create([
            'comment'=>$request->comment,
            'comment_date'=>$comment_date,
            'user_id'=>$request->user_id,
            'app_id'=>$request->app_id,
            ]);

        return response()->json(['message' =>'comentario creado correctamente' , 'comment'=> $comment]);

    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }






    }
    //update

    public function update(Request $request, $id)
{
    try {
        $request->validate([
            'comment' => 'required|string',
            'comment_date' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'app_id' => 'required|exists:apps,id',
        ]);

        $comment = Comment::findOrFail($id);
        $comment->update([
            'comment' => $request->comment,
            'comment_date' => $request->comment_date,
            'user_id' => $request->user_id,
            'app_id' => $request->app_id,
        ]);

        return response()->json(['message' => 'Comentario ha sido actualizado', 'comment' => $comment]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


    public function destroy($id){
        $comment=Comment::findOrFail($id);
        $comment->delete();
        return response()->json(['message'=> 'Comentario ha sido eliminado']);

    }
}

//apps
