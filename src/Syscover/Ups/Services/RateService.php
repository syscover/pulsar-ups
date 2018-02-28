<?php namespace Syscover\Ups\Services;

use Syscover\Ups\Facades\Rate;

class RateService
{
    public static function getRate(
        $countryFrom,
        $zipFrom,
        $countryTo,
        $zipTo,
        $weight
    )
    {
        return Rate::addUpsSecurity()
            ->addRequest()
            ->addShipper(
                $countryFrom,
                $zipFrom
            )
            ->addShipFrom(
                $countryFrom,
                $zipFrom
            )
            ->addShipTo(
                $countryTo,
                $zipTo
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