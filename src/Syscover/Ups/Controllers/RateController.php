<?php namespace Syscover\Ups\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Syscover\Ups\Services\RateService;

class RateController extends BaseController
{
    public function index(Request $request)
    {
        try
        {
            $object = RateService::getRate($request->all());
        }
        catch (\Exception $e)
        {
            return response()->json([
                'status'        => 500,
                'statusText'    => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status'        => 200,
            'statusText'    => 'success',
            'data'          => $object
        ]);
    }
}
