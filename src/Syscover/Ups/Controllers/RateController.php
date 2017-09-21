<?php namespace Syscover\Ups\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Ptondereau\LaravelUpsApi\Facades\UpsRate;
use Ups\Entity\Address;
use Ups\Entity\Dimensions;
use Ups\Entity\Package;
use Ups\Entity\PackagingType;
use Ups\Entity\ShipFrom;
use Ups\Entity\ShipTo;
use Ups\Entity\Shipment;
use Ups\Entity\UnitOfMeasurement;

class RateController extends BaseController
{
    public function index(Request $request)
    {
        try
        {
            // FROM
            // create address from
            $addressFrom = new Address();
            $addressFrom->setCountryCode('ES')
                ->setPostalCode('28020');

            // create ship from
            $shipFrom = new ShipFrom();
            $shipFrom->setAddress($addressFrom);

            //TO
            // create address to
            $addressTo = new Address();
            $addressTo->setCountryCode('ES')
                ->setPostalCode('28020');

            // create ship to
            $shipTo= new ShipTo();
            $shipTo->setAddress($addressTo);

            // create shipment
            $shipment = new Shipment();
            $shipment->setShipFrom($shipFrom);
            $shipment->setShipTo($shipTo);


            // crete package
            $package = new Package();
            $package->getPackagingType()->setCode(PackagingType::PT_PACKAGE);

            // WEIGHT
            $package->getPackageWeight()->setWeight(0.05);

            // set units weight
            $weightUnit = new UnitOfMeasurement;
            $weightUnit->setCode(UnitOfMeasurement::UOM_KGS);
            $package->getPackageWeight()->setUnitOfMeasurement($weightUnit);

            // DIMENSIONS
            $dimensions = new Dimensions();
            $dimensions->setHeight(10);
            $dimensions->setWidth(10);
            $dimensions->setLength(0.05);

            // set units dimensions
            $sizeUnit = new UnitOfMeasurement;
            $sizeUnit->setCode(UnitOfMeasurement::UOM_KGS);
            $dimensions->setUnitOfMeasurement($sizeUnit);

            $package->setDimensions($dimensions);

            // SET SHIPMENT
            $shipment->addPackage($package);

            $response = UpsRate::getRate($shipment);
        }
        catch (\Exception $e)
        {
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage()
            ]);
        }

        return response()->json($response);
    }
}
