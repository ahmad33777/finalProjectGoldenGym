<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use App\Models\Complaint;
use App\Models\Notification;
use App\Models\Offer;
use App\Models\PasswordReset;
use App\Models\Rating;
use App\Models\Subscriber;
use App\Models\Trainer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

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

    /**
     * Summary of showTrainers
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Summary of chaneTrainers
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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



    /**
     * Summary of forgetPassword
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgetPassword(Request $request)
    {
        $validator = validator($request->all(), [
            'email' => 'required|email',
        ]);

        try {
            if (!$validator->fails()) {
                $subscriber = Subscriber::where('email', $request->email)->get();
                if (count($subscriber) > 0) {

                    $token = Str::random(40);
                    $domain = URL::to('/');
                    $url = $domain . '/subscriber/reset-password?token=' . $token;

                    $data['url'] = $url;
                    $data['email'] = $request->email;
                    $data['title'] = 'Password Reset';
                    $data['body'] = 'من فضلك إضغط على الرابط التالي من أجل إعادة تعين كلمة المرور الخاصة بك';
                    Mail::to($request->email)->send(new ResetPasswordMail($data));
                    $dateTime = Carbon::now()->format('Y-m-d H:i:s');
                    PasswordReset::updateOrCreate(
                        ['email' => $request->email],
                        ['token' => $token, 'created_at' => $dateTime],
                    );

                    return response()->json(
                        [
                            'status' => true,
                            'message' => 'من فضلك افحص البريد الإلكتروني '
                        ],
                        200
                    );


                } else {
                    return response()->json(
                        [
                            'status' => false,
                            'message' => 'المستخدم غير موجود ؟؟'
                        ],
                        400
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


        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $e->getMessage(),
                ],
                403
            );
        }
    }



    /**
     * Summary of resetPasswordshow
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|mixed
     */
    public function resetPasswordshow(Request $request)
    {
        $resetData = DB::table('password_resets')->where('token', $request->token)->first();
        $subscriber = Subscriber::where('email', $resetData->email)->first();
        if (isset($resetData)) {
            $subscriber = Subscriber::where('email', $resetData->email)->first();
            return view('subscribers.password.resetPassword')->with('subscriber', $subscriber);
        } else {
            return view('errors.404');
        }

    }


    public function resetPassword(Request $request)
    {


         $request->validate([
            'id' => 'required|',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $sub = Subscriber::where('id', $request->id)->first();

        $sub->password = \Hash::make($request->password);

        $status = $sub->save();

        session()->flash('status', $status);
        return redirect()->back();
    }



}