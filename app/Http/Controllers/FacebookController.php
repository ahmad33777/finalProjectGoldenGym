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
        $token="***";
        $app_id = '***';
        $app_secret = '***';

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