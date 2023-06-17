<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TrainerComplaint;
use Illuminate\Http\Request;

class TrainerComplaintController extends Controller
{

    public function store(Request $request)
    {
        $validator = Validator(
            $request->all(),
            [
                'message' => 'required|string',
            ],
        );

        try {
            if (!$validator->fails()) {
                $message = $request->post('message');
    
                $newTrainerComplaint = new TrainerComplaint();
                $newTrainerComplaint->message = $message;
                $result = $newTrainerComplaint->save();
                
                if($result === true){
    
                    return response()->json(
                        [
                            'status' => true,
                            'messagae' => 'تم إرسال الشكوى أو الملاحظة',
                        ],
                        201
                    );
                }else{
    
                    return response()->json(
                        [
                            'status' => true,
                            'messagae' => 'فشل إرسال الشكوى',
                        ],
                        401
                    );
                }
    
            } else {
                return response()->json(
                    [
                        'status' => false,
                        'message' => $validator->getMessageBag()->first(),
                    ],
                    401
                );
            }
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status'=>false,
                    'message'=>$e->getMessage(),
                ]
            );
        }
        
        
    }


}