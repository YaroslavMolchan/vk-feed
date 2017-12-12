<?php

namespace App\Http\Controllers;

use App\Exceptions\LoginCallbackException;
use App\User;
use Illuminate\Http\Request;
use VK\VK;
use VK\VKException;

class LoginController extends Controller
{
    public function login()
    {
        $vk = new VK(env('VK_APP_ID'), env('VK_APP_SECRET'));

        return redirect()->to(
            $vk->getAuthorizeURL('wall,friends,offline')
        );
    }

}
