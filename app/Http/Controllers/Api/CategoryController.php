<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //


    public function showCategories()
    {
        $categores = Category::all();

        if ($categores) {
            return response()->json(
                [
                    'status' => true,
                    'categories' => $categores
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'لا يوجد فئات للعرض'
                ],
                200
            );
        }

    }
}