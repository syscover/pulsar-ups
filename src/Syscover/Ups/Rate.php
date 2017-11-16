<?php namespace Syscover\Ups;

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

    public function __construct(
        string $user,
        string $password,
        string $accessKey
    )
    {
        parent::__construct($user, $password, $accessKey);
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

    public function addShipper($name = null)
    {
        $this->request['RateRequest']['Shipment']['Shipper']['Name'] = 'XFEAT';
        $this->request['RateRequest']['Shipment']['Shipper']['ShipperNumber'] = $this->user;
        $this->request['RateRequest']['Shipment']['Shipper']['Address']['AddressLine'] = ['Calle orense 69'];
        $this->request['RateRequest']['Shipment']['Shipper']['Address']['PostalCode'] = '28020';
        $this->request['RateRequest']['Shipment']['Shipper']['Address']['CountryCode'] = 'ES';

        return $this;
    }

    public function addShipTo($countryCode, $postalCode, $name = null, $address = null, $city = null, $stateProvinceCode = null, $residentialAddressIndicator = null)
    {
        if($name) $this->request['RateRequest']['Shipment']['ShipTo']['Name'] = $name;
        if($address) $this->request['RateRequest']['Shipment']['ShipTo']['Address']['AddressLine'] = [$address];
        if($city) $this->request['RateRequest']['Shipment']['ShipTo']['Address']['City'] = $city;
        if($stateProvinceCode) $this->request['RateRequest']['Shipment']['ShipTo']['Address']['StateProvinceCode'] = $stateProvinceCode;
        if($postalCode) $this->request['RateRequest']['Shipment']['ShipTo']['Address']['PostalCode'] = $postalCode;
        $this->request['RateRequest']['Shipment']['ShipTo']['Address']['CountryCode'] = $countryCode;
        if($residentialAddressIndicator) $this->request['RateRequest']['Shipment']['ShipTo']['Address']['ResidentialAddressIndicator'] = $residentialAddressIndicator;

        return $this;
    }

    public function addShipFrom($country, $cp)
    {
        $this->request['RateRequest']['Shipment']['ShipFrom']['Name'] = 'XFEAT';
        $this->request['RateRequest']['Shipment']['ShipFrom']['Address']['AddressLine'] = ['Calle orense 69'];
        $this->request['RateRequest']['Shipment']['ShipFrom']['Address']['PostalCode'] = $cp;
        $this->request['RateRequest']['Shipment']['ShipFrom']['Address']['CountryCode'] = $country;

        return $this;
    }

    public function addService($code = Service::S_STANDARD)
    {
        $this->request['RateRequest']['Shipment']['Service']['Code'] = [$code];

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
        $this->request['RateRequest']['Shipment']['Package']['PackageWeight']['Weight'] = $weight;

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

        $response = $client->post(
            config('pulsar-ups.sandbox') ? self::SANDBOX_ENDPOINT : self::PRODUCTION_ENDPOINT . 'rest/Rate',
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

        return $response
            ->getBody()
            ->getContents();
    }
}