<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Notification;
use App\Models\Offer;
use App\Models\Rating;
use App\Models\Subscriber;
use App\Models\Trainer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class SubscriberController extends Controller
{



    // To show all Offers 

    public function showOffers()
    {
        $offers = Offer::where('deleted_at', null)->get();
        foreach ($offers as $offer) {
            $logo_link = Storage::url($offer->image);
            $offer->image = $logo_link;
        }
        if ($offers->isEmpty()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'لا يوجد عروض للعرض ',
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => true,
                    'offers' => $offers
                ],
                200
            );
        }


    }

    // To show all Notifications 
    public function showNotification()
    {
        $notifications = Notification::where('deleted_at', null)->get();

        if ($notifications->isEmpty()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'لا يوجد اشعارات للعرض',
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => true,
                    'notifications' => $notifications
                ],
                200
            );
        }


    }

   
    public function changePassword(Request $request)
    {
        $validator = Validator(
            $request->all(),
            [
                'old_password' => 'required',
                'password' => 'required|min:6|max:100',
                'confirm_password' => 'required|same:password',
                'subscriber_id' => 'required|numeric|'
            ],
        );
        if (!$validator->fails()) {
            $subscriber = Subscriber::find($request->subscriber_id);
            if (Hash::check($request->old_password, $subscriber->password)) {
                $trainer = Subscriber::find($subscriber->id);
                $trainer->password = Hash::make($request->password);
                $result = $trainer->save();
                if ($result) {
                    return response()->json(
                        [
                            'status' => true,
                            'message' => 'تم تحديث كلمة المرورو بنجاح'
                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            'status' => false,
                            'message' => 'فشلت عملة تغير كلمة المرور'
                        ],
                        200
                    );
                }

            } else {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'كلمة السر القديمة غير متطابقة !!'
                    ],
                    200
                );
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first(),
            ], 400);
        }

    }


    public function ratingStore(Request $request)
    {

        $validator = Validator(
            $request->all(),
            [
                'trainer_id' => 'required|numeric',
                'subscriber_id' => 'required|numeric',
                'rating' => 'required|numeric',
            ],
        );

        if (!$validator->fails()) {
            $now = Carbon::now();
            $currentDate = $now->toDateString();

            $rate = Rating::where('subscriber_id', $request->post('subscriber_id'))
                ->where('evaluation_date', $currentDate)
                ->get();
            if ($rate->isEmpty()) {
                $newRate = new Rating();
                $newRate->trainer_id = $request->post('trainer_id');
                $newRate->subscriber_id = $request->post('subscriber_id');
                $newRate->rating = $request->post('rating');

                $newRate->evaluation_date = $currentDate;
                $newRate->save();
                return response()->json(
                    [
                        'status' => true,
                        'message' => 'تم تقيم المدرب '
                    ],
                    201
                );
            } else {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'تم تقيم المدرب سابقاَ لا يمكن تقيمه مرتين',
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
                200
            );
        }
    }

    public function showTrainers()
    {
        $trainers = Trainer::select('id', 'name')->get();

        if (!$trainers->isEmpty()) {
            return response()->json(
                [
                    'status' => true,
                    'trainers' => $trainers
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'لايوجد مدربين للعرض حالياً'
                ],
                400
            );
        }
    }

    public function chaneTrainers(Request $request)
    {
        $validator = Validator(
            $request->all(),
            [
                'trainer_id' => 'required|numeric',
                'subscriber_id' => 'required|numeric',
            ],
        );
        try {
            if (!$validator->fails()) {
                $subscriber = Subscriber::find($request->post('subscriber_id'));
                $subscriber->trainer_id = $request->post('trainer_id');
                $status = $subscriber->save();
                if ($status) {
                    return response()->json(
                        [
                            'status' => true,
                            'message' => 'تم تحديث المدرب '
                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            'status' => false,
                            'message' => 'فشلت العملية '
                        ],
                        400
                    );
                }

            } else {
                return response()->json(
                    [
                        'status' => false,
                        'message' => $validator->getMessageBag()->first()
                    ],
                    400
                );
            }
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => true,
                    'message' => $e->getMessage(),
                ],
                400
            );
        }

    }



}