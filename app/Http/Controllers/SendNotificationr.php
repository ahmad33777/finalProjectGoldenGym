<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Subscriber;
use App\Models\Trainer;
use App\Models\User;
use App\Services\FCMService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SendNotificationr extends Controller
{


    public function index()
    {
        return view('notification.create');
    }
    public function sendNotification(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|string',
                'body' => 'required|string',
            ],
            [
                'title.required' => 'هذا الحقل مطلوب',
                'title.string' => 'يجب أن يكون نص',
                'body.required' => 'هذا الحقل مطلوب',
                'body.string' => 'يجب أن يكون نص'
            ]
        );

        $title = $request->title;
        $body = $request->body;

        $trainers = Trainer::all();
        foreach ($trainers as $trainer) {
            if ($trainer->fcm_token !== null) {
                FCMService::send(
                    $trainer->fcm_token,
                    [
                        'title' => $title,
                        'body' => $body,
                    ]
                );
            }

        }


        $subscribers = Subscriber::all();
        foreach ($subscribers as $subscriber) {
            if ($trainer->fcm_token !== null) {
                FCMService::send(
                    $subscriber->fcm_token,
                    [
                        'title' => $title,
                        'body' => $body,
                    ]
                );
            }

        }

        // Sore  notification to notification  table of db

        $newNotification = new Notification();
        $newNotification->title = $title;
        $newNotification->message = $body;

        $newNotification->save();
        session()->flash('status', true);
        return redirect()->route('create.notification');
    }
}