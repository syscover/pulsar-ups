<?php namespace Syscover\Ups\Services;

use Syscover\Core\Support\Number;
use Syscover\Market\Services\CatalogPriceRuleService;
use Syscover\ShoppingCart\Facades\CartProvider;
use Syscover\Ups\Facades\Rate;

class RateService
{
    public static function getRate($object)
    {
        if(empty($object['ship_from_country']))         throw new \Exception('You have to define a ship_from_country field to get a UPS rate');
        if(empty($object['ship_from_zip']))             throw new \Exception('You have to define a ship_from_zip field to create a UPS rate');
        if(empty($object['ship_to_country']))           throw new \Exception('You have to define a ship_to_country field to create a UPS rate');
        if(empty($object['ship_to_zip']))               throw new \Exception('You have to define a ship_to_zip field to create a UPS rate');
        if(empty($object['weight']))                    throw new \Exception('You have to define a weight field to create a UPS rate');

        // set shipper values if not exist
        if(empty($object['shipper_country']))           $object['shipper_country'] = $object['ship_from_country'];
        if(empty($object['shipper_zip']))               $object['shipper_zip'] = $object['ship_from_zip'];
        if(empty($object['shipper_name']))              $object['shipper_name'] = null;
        if(empty($object['set_cart']))                  $object['set_cart'] = false;
        if(empty($object['cart_instance']))             $object['cart_instance'] = 'default';

        // check catalog price rules to know if shipping is free
        $catalogPriceRuleResponse = CatalogPriceRuleService::checkFreeShipping($object);

        if ($catalogPriceRuleResponse['is_free'])
        {
            // set car value shipping rate
            if($object['set_cart'])
            {
                CartProvider::instance($object['cart_instance'])->shippingAmount = 0;
            }

            return [
                'status'        => 200,
                'status_text'   => 'success',
                'rate'          => 0,
                'is_free'       => true
            ];
        }

        // get rate
        $upsResponse =  Rate::addUpsSecurity()
            ->addRequest()
            ->addShipper(
                $object['shipper_country'],
                $object['shipper_zip'],
                $object['shipper_name']
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

        // calculate tax rate, by default 21%
        $upsResponse['tax']         = $object['tax'] ?? 21;
        $upsResponse['tax']         = (($upsResponse['tax'] + 100 )/ 100);
        $upsResponse['base_rate']   = $upsResponse['rate'];
        $upsResponse['rate']        = Number::roundUp($upsResponse['rate'] * $upsResponse['tax'], 2);

        // set car value shipping rate
        if($object['set_cart'])
        {
            CartProvider::instance($object['cart_instance'])->shippingAmount = $upsResponse['rate'];
        }

        return $upsResponse;
    }
}