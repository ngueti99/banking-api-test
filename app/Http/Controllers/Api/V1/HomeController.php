<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke()
    {
        $data =
        [
            'status' => 'success',
            'message' => 'welcome to banking api',
            'data' => [
                'service' => 'banking',
                'version' => '1.0',
                'languages' => app()->getLocale(),
                'support' => 'https://documenter.getpostman.com/view/19258099/2sA2rAzN7A',
            ]
            ];
        return response($data,200);
    }
}
