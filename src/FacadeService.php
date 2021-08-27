<?php
namespace Hsvisus\Sms;

use Illuminate\Support\Facades\Facade;

class FacadeService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'sms';
    }

}
