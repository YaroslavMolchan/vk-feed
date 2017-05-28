<?php

namespace App\Test;

class FirstHandler extends Handler
{
    public function process($request)
    {
        //do something
        echo 'first - '. $request . PHP_EOL;
    }
}