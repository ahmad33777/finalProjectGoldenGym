<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdcutController extends Controller
{
    //
    public function index()
    {

        $products = Product::all();
        foreach ($products as $product) {
            $logo_link = Storage::url($product->image);
            $product->image = $logo_link;
        }
        if (!$products->isEmpty()) {
            return response()->json(
                [
                    'status' => true,
                    'products' => $products
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'لايوجد  منتجات  للعرض'
                ],
                400
            );
        }
    }


    
}