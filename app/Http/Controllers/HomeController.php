<?php

namespace App\Http\Controllers;

use App\Exceptions\LoginCallbackException;
use App\User;
use Illuminate\Http\Request;
use VK\VK;
use VK\VKException;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index');
    }
}
