<?php namespace Syscover\Ups\Services;

use Syscover\Ups\Facades\Rate;

class RateService
{
    public static function getRate($countryFrom, $cpFrom, $countryTo, $cpTo, $weight)
    {
        Rate::addUpsSecurity()
            ->addRequest()
            ->addShipper()
            ->addShipFrom($countryFrom, $cpFrom)
            ->addShipTo($countryTo, $cpTo)
            ->addService()
            ->addPackage()
            ->addPackageWeight($weight)
            ->addShipmentRatingOptions();

        return Rate::send();





//        $rate = new Rate(
//            config('pulsar-ups.access_key'),
//            config('pulsar-ups.user_id'),
//            config('pulsar-ups.password')
//        );
//
//        // FROM
//        // create address from
//        $addressFrom = new Address();
//        $addressFrom->setCountryCode($countryFrom)
//            ->setPostalCode($cpFrom);
//
//        // create ship from
//        $shipFrom = new ShipFrom();
//        $shipFrom->setAddress($addressFrom);
//
//        //TO
//        // create address to
//        $addressTo = new Address();
//        $addressTo->setCountryCode($countryTo)
//            ->setPostalCode($cpTo);
//
//        // create ship to
//        $shipTo= new ShipTo();
//        $shipTo->setAddress($addressTo);
//
//        // create shipment
//        $shipment = new Shipment();
//        $shipment->setShipFrom($shipFrom);
//        $shipment->setShipTo($shipTo);
//
//
//        // crete package
//        $package = new Package();
//        $package->getPackagingType()->setCode(PackagingType::PT_UNKNOWN);
//
//        // WEIGHT
//        $package->getPackageWeight()->setWeight($weight);
//
//        // set units weight
//        $weightUnit = new UnitOfMeasurement;
//        $weightUnit->setCode(UnitOfMeasurement::UOM_KGS);
//        $package->getPackageWeight()->setUnitOfMeasurement($weightUnit);
//
//        // DIMENSIONS
//        //$dimensions = new Dimensions();
//        //$dimensions->setWidth($width);
//        //$dimensions->setHeight($height);
//        //$dimensions->setLength($length);
//
//        // set units dimensions
//        //$sizeUnit = new UnitOfMeasurement;
//        //$sizeUnit->setCode(UnitOfMeasurement::UOM_CM);
//        //$dimensions->setUnitOfMeasurement($sizeUnit);
//
//        //$package->setDimensions($dimensions);
//
//        // SET SHIPMENT
//        $shipment->addPackage($package);
//
//        return $rate->getRate($shipment);
    }
}