<?php namespace Syscover\Ups\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Syscover\Ups\Services\RateService;


class RateController extends BaseController
{
    public function index(Request $request)
    {
        $response = RateService::getRateCP(
            'ES',
            '20820',
            'ES',
            '28034',
            0.200,
            3.5,
            20.5,
            4.5
        );

        return response()->json($response);
    }
}
