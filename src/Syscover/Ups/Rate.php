<?php namespace Syscover\Ups;

use Illuminate\Support\Facades\Log;
use Syscover\Ups\Entities\PackagingType;
use Syscover\Ups\Entities\Service;
use Syscover\Ups\Entities\UnitOfMeasurement;

class Rate extends Ups
{
    const ENDPOINT = '/Rate';

    /**
     * @var array
     */
    private $request = [];

    /**
     * @var string
     */
    private $shipperNumber;

    /**
     * @var bool
     */
    private $debug = false;

    public function __construct(
        string $user,
        string $password,
        string $accessKey,
        string $shipperNumber = null
    )
    {
        parent::__construct($user, $password, $accessKey);

        $this->shipperNumber = $shipperNumber ? $shipperNumber : $user;
    }

    public function addUpsSecurity()
    {
        $this->request['UPSSecurity']['UsernameToken']['Username'] = $this->user;
        $this->request['UPSSecurity']['UsernameToken']['Password'] = $this->password;
        $this->request['UPSSecurity']['ServiceAccessToken']['AccessLicenseNumber'] = $this->accessKey;

        return $this;
    }

    public function addRequest($requestOption = 'Rate', $customerContext = 'UPS API Rate')
    {
        $this->request['RateRequest']['Request']['RequestOption'] = $requestOption;
        $this->request['RateRequest']['Request']['TransactionReference']['CustomerContext'] = $customerContext;

        return $this;
    }

    public function addShipper(
        $countryCode,
        $postalCode,
        $name = null,
        $address = null,
        $city = null,
        $stateProvinceCode = null
    )
    {
                                            $this->request['RateRequest']['Shipment']['Shipper']['ShipperNumber'] = $this->shipperNumber;
        if($name)                           $this->request['RateRequest']['Shipment']['Shipper']['Name'] = $name;
        if($address)                        $this->request['RateRequest']['Shipment']['Shipper']['Address']['AddressLine'] = [$address];
        if($city)                           $this->request['RateRequest']['Shipment']['Shipper']['Address']['City'] = $city;
        if($stateProvinceCode)              $this->request['RateRequest']['Shipment']['Shipper']['Address']['StateProvinceCode'] = $stateProvinceCode;
                                            $this->request['RateRequest']['Shipment']['Shipper']['Address']['PostalCode'] = $postalCode;
                                            $this->request['RateRequest']['Shipment']['Shipper']['Address']['CountryCode'] = $countryCode;

        return $this;
    }

    public function addShipFrom(
        $countryCode,
        $postalCode,
        $name = null,
        $address = null,
        $city = null,
        $stateProvinceCode = null
    )
    {
        if($name)                           $this->request['RateRequest']['Shipment']['ShipFrom']['Name'] = $name;
        if($address)                        $this->request['RateRequest']['Shipment']['ShipFrom']['Address']['AddressLine'] = [$address];
        if($city)                           $this->request['RateRequest']['Shipment']['ShipFrom']['Address']['City'] = $city;
        if($stateProvinceCode)              $this->request['RateRequest']['Shipment']['ShipFrom']['Address']['StateProvinceCode'] = $stateProvinceCode;
                                            $this->request['RateRequest']['Shipment']['ShipFrom']['Address']['PostalCode'] = $postalCode;
                                            $this->request['RateRequest']['Shipment']['ShipFrom']['Address']['CountryCode'] = $this->checkSpecialCountryCode($countryCode, $postalCode);

        return $this;
    }

    public function addShipTo(
        $countryCode,
        $postalCode,
        $name = null,
        $address = null,
        $city = null,
        $stateProvinceCode = null,
        $residentialAddressIndicator = null
    )
    {
        if($name)                           $this->request['RateRequest']['Shipment']['ShipTo']['Name'] = $name;
        if($address)                        $this->request['RateRequest']['Shipment']['ShipTo']['Address']['AddressLine'] = [$address];
        if($city)                           $this->request['RateRequest']['Shipment']['ShipTo']['Address']['City'] = $city;
        if($stateProvinceCode)              $this->request['RateRequest']['Shipment']['ShipTo']['Address']['StateProvinceCode'] = $stateProvinceCode;
        if($residentialAddressIndicator)    $this->request['RateRequest']['Shipment']['ShipTo']['Address']['ResidentialAddressIndicator'] = $residentialAddressIndicator;
                                            $this->request['RateRequest']['Shipment']['ShipTo']['Address']['PostalCode'] = $postalCode;
                                            $this->request['RateRequest']['Shipment']['ShipTo']['Address']['CountryCode'] = $this->checkSpecialCountryCode($countryCode, $postalCode);

        return $this;
    }

    public function addService($serviceCode = Service::S_STANDARD)
    {
        if($this->request['RateRequest']['Shipment']['ShipTo']['Address']['CountryCode'])
        {
            if(! $this->isServiceAllowed($serviceCode, $this->request['RateRequest']['Shipment']['ShipTo']['Address']['CountryCode']))
            {
                $serviceCode = $this->getSaverService($this->request['RateRequest']['Shipment']['ShipTo']['Address']['CountryCode']);
            }
        }
        else
        {
            throw new \Exception('ShipTo country code must be defined');
        }

        $this->request['RateRequest']['Shipment']['Service']['Code'] = [$serviceCode];

        return $this;
    }

    public function addPackage($code = PackagingType::PT_UNKNOWN)
    {
        $this->request['RateRequest']['Shipment']['Package']['PackagingType']['Code'] = [$code];

        return $this;
    }

    public function addPackageWeight($weight, $code = UnitOfMeasurement::UOM_KGS)
    {
        $this->request['RateRequest']['Shipment']['Package']['PackageWeight']['UnitOfMeasurement']['Code'] = $code;
        //$this->request['RateRequest']['Shipment']['Package']['PackageWeight']['UnitOfMeasurement']['Description'] = 'Kilos';
        $this->request['RateRequest']['Shipment']['Package']['PackageWeight']['Weight'] = (string) $weight;

        return $this;
    }

    public function addShipmentRatingOptions()
    {
        $this->request['RateRequest']['Shipment']['ShipmentRatingOptions']['NegotiatedRatesIndicator'] = '';

        return $this;
    }

    public function request()
    {
        return $this->request;
    }

    public function send()
    {
        $client = new \GuzzleHttp\Client();

        if($this->debug) return json_encode($this->request);

        $data = $client->post(
            (config('pulsar-ups.sandbox') ? self::SANDBOX_ENDPOINT : self::PRODUCTION_ENDPOINT) . 'rest' . self::ENDPOINT,
            [
                'json' => $this->request,
                'headers' => [
                    'Access-Control-Allow-Headers'  => 'Origin, X-Requested-With, Content-Type, Accept',
                    'Access-Control-Allow-Methods'  => 'POST',
                    'Access-Control-Allow-Origin'   => '*',
                    'Content-Type'                  => 'application/json'
                ],
                'Accept'        => 'application/json',
                'Content-Type'  => 'application/json',
                'http_errors'   => true
            ]
        );

        $rate = $data->getBody()->getContents();

        // parse string to object
        $rate = json_decode($rate);

        // register alerts
        if(is_array($rate->RateResponse->Response->Alert)) $this->alerts($rate->RateResponse->Response->Alert, 'Response');
        if(is_array($rate->RateResponse->RatedShipment->RatedShipmentAlert)) $this->alerts($rate->RateResponse->RatedShipment->RatedShipmentAlert, 'RatedShipment');

        if(isset($rate->RateResponse->RatedShipment->NegotiatedRateCharges->TotalCharge->MonetaryValue))
        {
            return [
                'status'        => 200,
                'status_text'   => 'success',
                'rate'          => (float) $rate->RateResponse->RatedShipment->NegotiatedRateCharges->TotalCharge->MonetaryValue,
                'is_free'       => false
            ];
        }
        elseif(isset($rate->Fault))
        {
            Log::error(
                'Syscover\Ups\Rate::send error with parameters',
                [
                    'status'        => $rate->Fault->detail->Errors->ErrorDetail->PrimaryErrorCode->Code,
                    'status_text'   => $rate->Fault->detail->Errors->ErrorDetail->PrimaryErrorCode->Description,
                    'request'       => $this->request
                ]);

            return [
                'status'        => $rate->Fault->detail->Errors->ErrorDetail->PrimaryErrorCode->Code,
                'status_text'   => $rate->Fault->detail->Errors->ErrorDetail->PrimaryErrorCode->Description
            ];
        }
        else
        {
            return [
                'status'        => 500,
                'status_text'   => 'UPS Internal Server Error, unknown error'
            ];
        }
    }

    private function checkSpecialCountryCode($countryId, $zip)
    {
        // get countries from special countries table
        $country = collect(config('pulsar-ups.country_codes'))->get($countryId);

        if(is_array($country))
        {
            $zipPattern = $zip;
            for ($i = strlen($zip); $i > 0; $i--)
            {
                $zipPattern = substr_replace($zipPattern,'*', $i-1, 1);
                if(array_key_exists($zipPattern, $country))
                {
                   return $country[$zipPattern];
                }
            }
        }

        return $countryId;
    }

    private function getSaverService($countryId)
    {
        // get countries from special countries table
        $countryServices = collect(config('pulsar-ups.services'))->get($countryId);

        if(is_array($countryServices))
        {
            $saverService = collect($countryServices)->where('saver', true)->first();

            if($saverService)
                if(isset($saverService['code']))
                    return $saverService['code'];
                else
                    throw new \Exception('Code parameter must be defined in config pulsar-ups.services');
            else
                return null;
        }

        return null;
    }

    /**
     * Check if service is allowed for ShipTo country code
     *
     * @param $serviceCode
     * @param $countryId
     * @return bool
     */
    private function isServiceAllowed($serviceCode, $countryId)
    {
        // get countries from special countries table
        $countryServices = collect(config('pulsar-ups.services'))->get($countryId);

        if(is_array($countryServices))
            return collect($countryServices)->where('code', $serviceCode)->count() > 0;

        return true;
    }
}