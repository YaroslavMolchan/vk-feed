<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Cookie;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $telegram_id = $request->cookie('telegram_id');

        return view('home', compact('telegram_id'));
    }

    public function telegram($id)
    {
        $cookie = new Cookie('telegram_id', $id);

        return redirect()->route('home')->cookie($cookie);
    }
}
