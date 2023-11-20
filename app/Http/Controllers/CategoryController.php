<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //obtener todos los comentarios
    public function index(){
        $categories = category::all();
        $transformedCategories = $categories->map(function ($category) {
            return [
                'value' => $category->id,
                'name' => $category->category_name,
            ];
        });

        return response()->json(['categories' => $transformedCategories]);
    }

}