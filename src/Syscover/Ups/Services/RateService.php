<?php namespace Syscover\Ups\Services;

use Syscover\Market\Services\CatalogPriceRuleService;
use Syscover\Ups\Facades\Rate;

class RateService
{
    public static function getRate($object)
    {
        if(empty($object['ship_from_country'])) throw new \Exception('You have to define a ship_from_country field to get a UPS rate');
        if(empty($object['ship_from_zip']))     throw new \Exception('You have to define a ship_from_zip field to create a UPS rate');
        if(empty($object['ship_to_country']))   throw new \Exception('You have to define a ship_to_country field to create a UPS rate');
        if(empty($object['ship_to_zip']))       throw new \Exception('You have to define a ship_to_zip field to create a UPS rate');
        if(empty($object['weight']))            throw new \Exception('You have to define a weight field to create a UPS rate');

        // set shipper values if not exist
        if(empty($object['shipper_country']))   $object['shipper_country'] = $object['ship_from_country'];
        if(empty($object['shipper_zip']))       $object['shipper_zip'] = $object['ship_from_zip'];

        // check catalog price rules to know if shipping is free
        $response = CatalogPriceRuleService::checkFreeShipping($object);

        if ($response['is_free'])
        {
            return [
                'status'        => 200,
                'status_text'   => 'success',
                'rate'          => 0,
                'is_free'       => true
            ];
        }

        // get rate
        return Rate::addUpsSecurity()
            ->addRequest()
            ->addShipper(
                $object['shipper_country'],
                $object['shipper_zip']
            )
            ->addShipFrom(
                $object['ship_from_country'],
                $object['ship_from_zip']
            )
            ->addShipTo(
                $object['ship_to_country'],
                $object['ship_to_zip']
            )
            ->addService()
            ->addPackage()
            ->addPackageWeight(
                $object['weight']
            )
            ->addShipmentRatingOptions()
            ->send();
    }
}