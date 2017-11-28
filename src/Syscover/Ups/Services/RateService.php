<?php namespace Syscover\Ups\Services;

use Syscover\Ups\Facades\Rate;

class RateService
{
    public static function getRate(
        $countryFrom,
        $cpFrom,
        $countryTo,
        $cpTo,
        $weight
    )
    {
        return Rate::addUpsSecurity()
            ->addRequest()
            ->addShipper()
            ->addShipFrom(
                $countryFrom,
                $cpFrom
            )
            ->addShipTo(
                $countryTo,
                $cpTo
            )
            ->addService()
            ->addPackage()
            ->addPackageWeight(
                $weight
            )
            ->addShipmentRatingOptions()
            ->send();

        //return Rate::send();
        //return json_encode(Rate::request());
    }
}