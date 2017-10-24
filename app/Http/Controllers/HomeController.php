<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Cookie;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $telegramId = $request->cookie('telegramId');

        return view('home', compact('telegramId'));
    }

    public function telegram($id)
    {
        $cookie = new Cookie('telegramId', $id);

        return redirect()->route('home')->cookie($cookie);
    }
}
