<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SmsController extends Controller
{
    //
    /**
     * Summary of sms
     * @param mixed $password
     * @return void
     */
    public static function sms($password)
    {
        $basic = new \Vonage\Client\Credentials\Basic("a902e196", "DGVgO5m0tl9geLu8");
        $client = new \Vonage\Client($basic);

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS("972597701597", 'GoldenGym |  passowd :', $password)
        );

        $message = $response->current();

        // if ($message->getStatus() == 0) {
        //     r
        //     echo "The message was sent successfully\n";

        // } else {
        //     echo "The message failed with status: " . $message->getStatus() . "\n";
        // }
    }
}