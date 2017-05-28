<?php

namespace App\Test;

class ThirdHandler extends Handler
{
    public function process($request)
    {
        //do something
        echo 'third - '. $request . PHP_EOL;
    }
}