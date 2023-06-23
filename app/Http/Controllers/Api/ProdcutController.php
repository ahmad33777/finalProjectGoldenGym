<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdcutController extends Controller
{
    //
    public function getAllProteins()
    {

        $products = Product::Where("category_id",1)->get();
        foreach ($products as $product) {
            $logo_link = Storage::url($product->image);
            $product->image = $logo_link;
        }
        if (!$products->isEmpty()) {
            return response()->json(
                [
                    'status' => true,
                    'protins' => $products
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'لايوجد  بروتينات  للعرض'
                ],
                200
            );
        }
    }

    public function getAllSportsEquipment()
    {

        $products = Product::Where("category_id",2)->get();
        foreach ($products as $product) {
            $logo_link = Storage::url($product->image);
            $product->image = $logo_link;
        }
        if (!$products->isEmpty()) {
            return response()->json(
                [
                    'status' => true,
                    'Sports equipment' => $products
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'لايوجد معدات ومستلزمات رياضية للعرض'
                ],
                200
            );
        }
    }


    
}