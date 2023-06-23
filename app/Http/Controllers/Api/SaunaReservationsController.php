<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SaunaReservations;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isEmpty;

class SaunaReservationsController extends Controller
{
    public $maximumReservations = 10; // Maximum number of reservations allowed

    //دالة الحجز 
    public function reservation(Request $request)
    {
        $validator = Validator(
            $request->all(),
            [
                'subscriber_id' => 'required|numeric|exists:subscribers,id',
                'booking_date' => 'required|date',
                // |date
                'start_time' => 'required',
                // |date_format:H:i
            ],
        );
        if (!$validator->fails()) {
            $subscriber_id = $request->post('subscriber_id');
            $booking_date = $request->post('booking_date');
            $start_time = $request->post('start_time');
            $timestamp = strtotime($start_time);
            $newTimestamp = $timestamp + (60 * 60); // Add one hour in seconds
            $end_time = date("H:i", $newTimestamp);

            // عدد الحجوزات الموجودة
            $existingReservationsCount = SaunaReservations::
                where('booking_date', $booking_date)
                ->where('start_time', '>=', $request->post('start_time'))
                ->where('end_time', '<=', $end_time)
                ->where('deleted_at', null)
                ->count();

            if ($existingReservationsCount < $this->maximumReservations) {
                $reservations = SaunaReservations::updateOrCreate(
                    ['subscriber_id' => $subscriber_id],
                    // to search 
                    [
                        'subscriber_id' => $subscriber_id,
                        'booking_date' => $booking_date,
                        'start_time' => $start_time,
                        'end_time' => $end_time,
                        'deleted_at' => null,
                    ]
                );
                if ($reservations ?? false) {
                    return response()->json(['status' => true, 'message' => 'تم الحجز بنجاح يرجى التوجه للمحاسب من اجل دفع الرسوم'], 200);
                } else {
                    return response()->json(['status' => false, 'message' => 'فشل الحجز حاول مرة اخرى من فضلك'], 200);
                }

            } else {
                return response()->json(['status' => false, 'message' => 'الحجز مكتمل لهذه الساعة , من فضلك اختار ساعة اخرة او يوم أخر'], 200);
            }
        } else {
            return response()->json(['status' => false, 'message' => $validator->getMessageBag()->first()], 400);
        }


    }
    //دالة إلغاء الحجز 
    public function cancellationReservation(Request $request)
    {
        $validator = Validator(
            $request->all(),
            [
                'subscriber_id' => 'required|numeric|exists:sauna_reservations,subscriber_id',
                'reservation_id' => 'required|numeric|exists:sauna_reservations,id',
            ],
        );
        if (!$validator->fails()) {
            $saunaReservations = SaunaReservations::
                where('id', $request->post('reservation_id'))
                ->where('subscriber_id', $request->post('subscriber_id'))
                ->where('deleted_at', null)
                ->first();
            $saunaReservations->deleted_at = now()->format('Y-m-d H:i:s');
            $status = $saunaReservations->save();
            if ($status ?? false) {
                return response()->json(['status' => true, 'message' => 'تم إلغاء  الحجز'], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'حاول مرة اخرى'], 200);
            }
        } else {
            return response()->json(['status' => false, 'message' => $validator->getMessageBag()->first()], 400);
        }
    }
    // دالة عرض الحجوزات 
    public function showReservations(Request $request)
    {
        $validator = Validator($request->all(), ['subscriber_id' => 'required|numeric|exists:sauna_reservations,subscriber_id']);

        if (!$validator->fails()) {
            $saunaReservations = SaunaReservations::
                where('subscriber_id', $request->post('subscriber_id'))
                ->where('deleted_at', null)
                ->get();

            if (!$saunaReservations->isEmpty()) {
                return response()->json(['status' => true, 'saunaReservations' => $saunaReservations], 200);
            } else {
                return response()->json(['status' => false, "message" => "لا يوجد حجوزات ساونا لعرضها"], 200);

            }

        } else {
            return response()->json(['status' => false, 'message' => $validator->getMessageBag()->first()], 400);
        }

    }

}