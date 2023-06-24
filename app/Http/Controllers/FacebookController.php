<?php

namespace App\Http\Controllers;

use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Illuminate\Http\Request;

class FacebookController extends Controller
{

    public function create()
    {
        return view('facebook.createPost');

    }

    public function createPost(Request $request)
    {
        $token = "EAAMfWY0a5koBALlwYROgvwxGe4pZAffArYmuOFnepma0rZAPR7QtdcyPcd1xaZBU4uIXQ3hKevivfC0doI4cpZAiiJ50IlYVGYpkh4unrUwZBhoFauG7PLygfuT0mZAZCs7pxQUbgYyoxKY9XQnomzbc1wv5O6arPHil0bZBLloIxJkSfujl2zHPrMA4zp8fKzP5Qd1ZBHqcBGQZDZD";
        $app_id = '878894410032714';
        $app_secret = 'e08e7f275a6ad63938b3f23a409ab4d9';

        $fb = new Facebook([
            'app_id' => $app_id,
            'app_secret' => $app_secret,
            'default_graph_version' => 'v3.3',
        ]);

        $fb->setDefaultAccessToken($token);
        $post=[
            'message' => 'test post' ,
        ];
        $response = $fb->post('/me/feed', $post);
        $graphNode = $response->getGraphNode();
        if ($graphNode) {
            session()->flash('status', true);
            return redirect()->route('create-post');
        } else {
            session()->flash('status', false);
            return redirect()->route('create-post');

        }
    }
}