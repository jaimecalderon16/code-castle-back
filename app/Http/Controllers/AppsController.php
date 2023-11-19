<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\apps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Carbon;

class AppsController extends Controller
{
    public function index()
    {
        try {
            $apps = apps::all();
            return response()->json(['message' => 'Consulta exitosa', 'apps' => $apps], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



    public function show($id){
        $apps=apps::findOrFail($id);
        return response()->json($apps);
    }

    public function store(Request $request)
    {
        try {
            $date = Carbon::now();

            $request->validate([
                'application_name' => 'required|string|max:255',
                'description' => 'required|string',
                'download_link' => 'required|url',
                'user_id' => 'required|exists:users,id',
            ]);

            $app = apps::create([
                'application_name' => $request->application_name,
                'description' => $request->description,
                'download_link' => $request->download_link,
                'qualification' => $request->qualification,
                'upload_date' => $date,
                'n_downloads' => $request->n_downloads,
                'user_id' => $request->user_id,
            ]);

            return response()->json($app, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // public function store( Request $request){
    //     $request->validate([
    //         'application_name'=>'required|string|max:255',
    //         'description' => 'required|string',
    //         'download_link'=>'required|url',
    //         'qualification'=> 'required|numeric|min:0|max:5',
    //         'upload_date' => 'required|date',
    //         'n_downloads'=>'required|integer|min:0',
    //         'user_id'=>'required|exists:users,id',
    //     ]);


    //     $apps=apps::create([
    //         'application_name'=> $request -> application_name,
    //         'description'=> $request->description,
    //         'download_link'=> $request->download_link,
    //         'qualification'=>$request-> qualification,
    //         'upload_date'=>$request->upload_date,
    //         'n_downloads'=> $request->n_downloads,
    //         'user_id'=>$request->user_id,
    //     ]);
    //     return response()->json( $apps,201);

    // }

       // Actualizar una aplicación existente
public function update(Request $request, $id)
{
    try {
        $request->validate([
            'application_name' => 'required|string|max:255',
            'description' => 'required|string',
            'download_link' => 'required|url',
            'qualification' => 'required|numeric|min:0|max:5',
            'upload_date' => 'required|date',
            'n_downloads' => 'required|integer|min:0',
            'user_id' => 'required|exists:users,id',
        ]);

        $app = apps::findOrFail($id);
        $app->update($request->all());

        return response()->json($app, 200); // 200: OK
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


        // Eliminar una aplicación
        public function destroy($id)
        {
            try {
                $app = apps::findOrFail($id);
                $app->delete();

                return response()->json(null, 204); // 204: No Content
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
}
