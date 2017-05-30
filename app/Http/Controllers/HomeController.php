<?php

namespace App\Http\Controllers;

use App\Exceptions\LoginCallbackException;
use App\User;
use Illuminate\Http\Request;
use VK\VK;
use VK\VKException;

class HomeController extends Controller
{
    public function index(Request $request, $telegram_id = null)
    {
        dd($telegram_id);
        return view('home.index');
    }
}
