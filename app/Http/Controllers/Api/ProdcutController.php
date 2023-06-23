<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdcutController extends Controller
{
     

    
    public function showProducts(Request $request)
    {
        $validator = Validator(
            $request->all(),
            [
                'category_id' => 'required|numeric',
            ],
        );

        if(!$validator->fails()){
            $products =  Product::where('category_id', $request->post('category_id'))->get();
            foreach ($products as $product) {
                $logo_link = Storage::url($product->image);
                $product->image = $logo_link;
            }
              if($products->isEmpty()){
                return response()->json(
                    [
                        'status'=>false,
                        'message'=>'لا يوجد منتجات للعرض'
                    ],200
                   ); 
              }else{
                return response()->json(
                    [
                        'status'=>true,
                        'products'=>$product
                    ],200
                   ); 
                
              }
                
        }else{
            return response()->json(
                [
                    'status'=>false,
                    'message'=>$validator->getMessageBag()->first(),
                ],
            );
            
        }

        

    }



}