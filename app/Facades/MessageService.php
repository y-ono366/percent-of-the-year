<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
class MessageService extends Facade
{
    protected static function getFacadeAccessor() {
        return 'MessageService';
    }
}
