<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Subscriber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{

    // store order in Database
    public function order(Request $request)
    {
        $validator = validator($request->all(), [
            'subscriber_id' => 'required|numeric|exists:subscribers,id',
            'product_id' => 'required|numeric|exists:products,id',
        ]);

        if (!$validator->fails()) {
            $subscriber_id = $request->post('subscriber_id');
            $product_id = $request->post('product_id');
            $newOrder = new Order();
            $now = Carbon::now();
            $currentDate = $now->toDateString();
            $newOrder->subscriber_id = $subscriber_id;
            $newOrder->product_id = $product_id;
            $newOrder->order_date = $currentDate;

            $status = $newOrder->save();
            if ($status) {
                return response()->json(
                    [
                        'status' => true,
                        'message' => 'تم ارسال الحجز بنجاح'
                    ],
                    201
                );
            } else {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'فشل ارسال الحجز '
                    ],
                    20
                );
            }
        } else {
            return response(
                [
                    'status' => false,
                    'message' => $validator->getMessageBag()->first(),
                ],
                400
            );
        }
    }


    public function cancellingOrder(Request $request)
    {

        $validator = validator($request->all(), [
            'subscriber_id' => 'required|numeric|exists:subscribers,id',
            'pivot_id' => 'required|numeric|exists:orders,id',
        ]);

        if (!$validator->fails()) {
            $subscriber_id = $request->post('subscriber_id');
            $pivot_id = $request->post('pivot_id');
            $status = Order::where('id', $pivot_id)->where('subscriber_id', $subscriber_id)->forceDelete();
            if ($status) {
                return response()->json(
                    [
                        'status' => true,
                        'message' => 'تم التراجع عن حجز المنتج'
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'فشل التراجع عن حجز المنتج'
                    ],
                    200
                );
            }

        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => $validator->getMessageBag()->first(),
                ],
                400
            );
        }


    }

    public function showMyOrders(Request $request)
    {

        $validator = validator($request->all(), [
            'subscriber_id' => 'required|numeric|exists:subscribers,id',
        ]);
        if (!$validator->fails()) {

            $subscriber = Subscriber::find($request->post('subscriber_id'));
            $orders = $subscriber->orders;

            foreach ($orders as $order) {
                $logo_link = Storage::url($order->image);
                $order->image = $logo_link;
            }

            if (!$orders->isEmpty()) {
                return response(
                    [
                        'status' => true,
                        'orders' => $orders
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'لا يوجد  حجوزات'
                    ],
                    200
                );
            }



        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => $validator->getMessageBag()->first(),
                ],
                400
            );

        }

    }
}