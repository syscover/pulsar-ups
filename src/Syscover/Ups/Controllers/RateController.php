<?php namespace Syscover\Ups\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Syscover\Ups\Services\RateService;


class RateController extends BaseController
{
    public function index(Request $request)
    {
        $response = RateService::getRate(
            'ES',
            '28020',
            'ES',
            '28034',
            '0.2'
        );

        return response($response);
    }
}
