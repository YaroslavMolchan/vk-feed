<?php

namespace App\Test;

class SecondHandler extends Handler
{
    public function process($request)
    {
        //do something
        echo 'second - '. $request . PHP_EOL;
    }
}