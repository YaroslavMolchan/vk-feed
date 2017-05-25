<?php

namespace App\Http\Controllers;

use VK\VK;

class AuthController extends Controller
{
    public function login()
    {
        $vk = new VK(env('VK_APP_ID'), env('VK_API_SECRET'));

//       echo $vk->getAuthorizeURL('messages');
       echo $vk->getAuthorizeURL('wall,friends', 'http://localhost:8000/auth/callback');
//       echo $vk->getAuthorizeURL('messages', 'http://localhost:8000/auth/blank.html');

    }

    public function callback()
    {
        dd($_REQUEST);
        $vk = new VK(env('VK_APP_ID'), env('VK_API_SECRET'));

        $vk->getAccessToken('{CODE}');
    }
}
