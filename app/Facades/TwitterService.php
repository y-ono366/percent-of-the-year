<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
class TwitterService extends Facade
{
    protected static function getFacadeAccessor() {
        return 'TwitterService';
    }
}
