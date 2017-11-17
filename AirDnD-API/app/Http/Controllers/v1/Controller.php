<?php

namespace App\Http\Controllers\v1;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public $api = '1.0';

    public function home()
    {
        return 'AirDnD API ' . $this->api;
    }
}
