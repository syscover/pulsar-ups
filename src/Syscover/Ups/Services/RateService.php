<?php namespace Syscover\Ups\Services;

use Ptondereau\LaravelUpsApi\Facades\UpsRate;
use Ups\Entity\Address;
use Ups\Entity\Dimensions;
use Ups\Entity\Package;
use Ups\Entity\PackagingType;
use Ups\Entity\ShipFrom;
use Ups\Entity\ShipTo;
use Ups\Entity\Shipment;
use Ups\Entity\UnitOfMeasurement;

class RateService
{
    public static function getRate($countryFrom, $cpFrom, $countryTo, $cpTo, $weight, $width, $height, $length)
    {
        // FROM
        // create address from
        $addressFrom = new Address();
        $addressFrom->setCountryCode($countryFrom)
            ->setPostalCode($cpFrom);

        // create ship from
        $shipFrom = new ShipFrom();
        $shipFrom->setAddress($addressFrom);

        //TO
        // create address to
        $addressTo = new Address();
        $addressTo->setCountryCode($countryTo)
            ->setPostalCode($cpTo);

        // create ship to
        $shipTo= new ShipTo();
        $shipTo->setAddress($addressTo);

        // create shipment
        $shipment = new Shipment();
        $shipment->setShipFrom($shipFrom);
        $shipment->setShipTo($shipTo);


        // crete package
        $package = new Package();
        $package->getPackagingType()->setCode(PackagingType::PT_UNKNOWN);

        // WEIGHT
        $package->getPackageWeight()->setWeight($weight);

        // set units weight
        $weightUnit = new UnitOfMeasurement;
        $weightUnit->setCode(UnitOfMeasurement::UOM_KGS);
        $package->getPackageWeight()->setUnitOfMeasurement($weightUnit);

        // DIMENSIONS
        $dimensions = new Dimensions();
        $dimensions->setWidth($width);
        $dimensions->setHeight($height);
        $dimensions->setLength($length);

        // set units dimensions
        $sizeUnit = new UnitOfMeasurement;
        $sizeUnit->setCode(UnitOfMeasurement::UOM_CM);
        $dimensions->setUnitOfMeasurement($sizeUnit);

        $package->setDimensions($dimensions);

        // SET SHIPMENT
        $shipment->addPackage($package);

        return UpsRate::getRate($shipment);

    }
}