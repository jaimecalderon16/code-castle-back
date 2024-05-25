<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\apps;
use App\Models\TagsApp;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AppsController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Obtener los registros que tienen 'category_id' diferente de 1
            if ($request->has('isVidegame') && !empty($request->query('isVidegame'))) {

                $apps = apps::where('category_id', '=', 1)->get();
            }else{
                $apps = apps::where('category_id', '!=', 1)->get();
            }


            // Transformar los registros
            $transformedApps = $apps->map(function ($app) {
                return [
                    'id' => $app->id,
                    'name' => $app->aplication_name,
                    'description' => $app->description,
                    'download_link' => $app->download_link,
                    'calificacion' => rand(3, 5),
                    'n_downloads' => $app->n_downloads,
                    'user_id' => $app->user_id,
                    'comapy' => $app->company,
                    'version' => $app->version,
                    'img_path' => str_replace('public', 'storage', $app->img_path),
                ];
            });

            // Devolver la respuesta JSON con los datos transformados
            return response()->json(['message' => 'Consulta exitosa', 'apps' => $transformedApps], 200);
        } catch (\Exception $e) {
            // Manejar excepciones y devolver un error en formato JSON
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function search(Request $request)
    {
        try {

            $apps = apps::where('aplication_name', 'like', '%' . $request->name . '%')->get();

            $transformedApps = $apps->map(function ($app){
                return [
                    'id' => $app->id,
                    'name' => $app->aplication_name,
                    'description' => $app->description,
                    'download_link' => $app->download_link,
                    'calificacion' =>  rand(3, 5),
                    'n_downloads' => $app->n_downloads,
                    'user_id' => $app->user_id,
                    'comapy' => $app->company,
                    'version' => $app->version,
                    'img_path' =>  str_replace('public', 'storage',$app->img_path),
                ];
            });
            return response()->json(['message' => 'Consulta exitosa', 'apps' => $transformedApps], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function downloadSave($id)
    {
        $data = apps::find($id); // Asumiendo que el modelo se llama 'App' y no 'apps'

        if (!$data) {
            return response()->json(['error' => 'No se encontró la aplicación'], 404);
        }

        $nDownloads = $data->n_downloads + 1; // Corregir la variable
        $data->n_downloads = $nDownloads;
        $data->save();

        return response()->json($data);
}

    public function show($id){
        $data = apps::with('tags')->findOrFail($id);
        $app = [
            "id" => $data->id,
            "imagen" => str_replace('public','storage', $data?->img_path),
            "nombre" => $data->aplication_name,
            "descripcion" => $data->description,
            "version" => $data->version,
            "calificacion" => rand(3, 5),
            "company" => $data->company,
            "actualizacion" => $data->upload_date,
            "descargas" => $data->descargas,
            "tamaño" => $data->size,
            "urlDescarga" => $data->download_link,
            "tags" => $data->tags,
            "requerimientos" => $data->requirements,
            "descargas" => $data->n_downloads ?? 0,
        ];
        return response()->json($app);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $date = Carbon::now();

            $request->validate([
                'application_name' => 'required|string|max:255',
                'description' => 'required|string',
                'version' => 'required|string',
                'company' => 'required|string',
                'imgFile' => 'required|File',
                'appFile' => 'required|File',
                'user_id' => 'required|exists:users,id',
                'requirements' => 'required|string',
            ]);

            $fileImg = $request->file('imgFile');
            $fileNameImg = uniqid() . '.' . $fileImg->getClientOriginalExtension();

            // Almacenar la imagen en la carpeta storage/app
            $filePath = $fileImg->storeAs('public', $fileNameImg);

            $fileApp = $request->file('appFile');
            $fileNameApp = uniqid() . '.' . $fileApp->getClientOriginalExtension();

            // Almacenar la app en la carpeta storage/app
            $filePathApp = $fileApp->storeAs('public', $fileNameApp);
            $fileSize = $fileApp->getSize();
            $fileSizeMB = $fileSize / (1024 * 1024);

            $app = apps::create([
                'aplication_name' => $request->input('application_name'),
                'description' => $request->input('description'),
                'version' => $request->input('version'),
                'company' => $request->input('company'),
                'upload_date' => $date,
                'img_path' => str_replace('public', 'storage',$filePath),
                'download_link' => str_replace('public', 'storage',$filePathApp),
                'user_id' => $request->input('user_id'),
                'requirements' => $request->input('requirements'),
                'category_id' => $request->input('categoria_id'),
                'requirements' => $request->input('requirements'),
                'size' => $fileSizeMB,
            ]);

            $tags = $request->input('tags');
            $tags = json_decode($tags);

            foreach ($tags as $tag) {
                $tagModel = new TagsApp();
                $tagModel->name = $tag;
                $tagModel->app_id = $app->id;
                $tagModel->save();
            }

            DB::commit();
            return response()->json(['message' => 'aplicacion creada correctamente', 'data' => $app], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


public function update(Request $request, $id)
{
    try {
        $request->validate([
            'application_name' => 'required|string|max:255',
            'description' => 'required|string',
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
