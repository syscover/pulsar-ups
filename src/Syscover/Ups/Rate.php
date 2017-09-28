<?php namespace Syscover\Ups;

class Rate {

    private $user;
    private $password;
    private $accessKey;
    private $request = [];

    public function __construct(
        string $user,
        string $password,
        string $accessKey
    )
    {
        $this->user = $user;
        $this->password = $password;
        $this->accessKey = $accessKey;
    }

    public function addUpsSecurity()
    {
        $this->request['UPSSecurity']['UsernameToken']['Username'] = $this->user;
        $this->request['UPSSecurity']['UsernameToken']['Password'] = $this->password;
        $this->request['UPSSecurity']['ServiceAccessToken']['AccessLicenseNumber'] = $this->accessKey;

        return $this;
    }

    public function addRequest()
    {
        $this->request['RateRequest']['Request']['RequestOption'] = 'Rate';
        $this->request['RateRequest']['Request']['TransactionReference']['CustomerContext'] = 'Your Access Context';

        return $this;
    }

    public function addShipper()
    {
        $this->request['RateRequest']['Shipment']['Shipper']['Name'] = 'XFEAT';
        $this->request['RateRequest']['Shipment']['Shipper']['ShipperNumber'] = $this->user;
        $this->request['RateRequest']['Shipment']['Shipper']['Address']['AddressLine'] = ['Calle orense 69'];
        $this->request['RateRequest']['Shipment']['Shipper']['Address']['PostalCode'] = '28020';
        $this->request['RateRequest']['Shipment']['Shipper']['Address']['CountryCode'] = 'ES';

        return $this;
    }

    public function addShippTo()
    {
        $this->request['RateRequest']['Shipment']['ShipTo']['Name'] = 'Carlos';
        $this->request['RateRequest']['Shipment']['ShipTo']['Address']['AddressLine'] = ['Calle antonio de cabezón 83'];
        $this->request['RateRequest']['Shipment']['ShipTo']['Address']['PostalCode'] = '28034';
        $this->request['RateRequest']['Shipment']['ShipTo']['Address']['CountryCode'] = 'ES';

        //$this->request['RateRequest']['Shipment']['ShipTo']['Address']['PostalCode'] = '75014';
        //$this->request['RateRequest']['Shipment']['ShipTo']['Address']['CountryCode'] = 'FR';

        return $this;
    }

    public function addShippFrom()
    {
        $this->request['RateRequest']['Shipment']['ShipFrom']['Name'] = 'XFEAT';
        $this->request['RateRequest']['Shipment']['ShipFrom']['Address']['AddressLine'] = ['Calle orense 69'];
        $this->request['RateRequest']['Shipment']['ShipFrom']['Address']['PostalCode'] = '28020';
        $this->request['RateRequest']['Shipment']['ShipFrom']['Address']['CountryCode'] = 'ES';

        return $this;
    }

    public function addService()
    {
        $this->request['RateRequest']['Shipment']['Service']['Code'] = ['11'];

        return $this;
    }

    public function addPackage()
    {
        $this->request['RateRequest']['Shipment']['Package']['PackagingType']['Code'] = ['00'];

        return $this;
    }

    public function addPackageWeight()
    {
        $this->request['RateRequest']['Shipment']['Package']['PackageWeight']['UnitOfMeasurement']['Code'] = 'KGS';
        $this->request['RateRequest']['Shipment']['Package']['PackageWeight']['UnitOfMeasurement']['Description'] = 'Kilos';
        $this->request['RateRequest']['Shipment']['Package']['PackageWeight']['Weight'] = '0.2';

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
            'https://wwwcie.ups.com/rest/Rate',
            [
                'json' => $this->request,
                'headers' => [
                    'Access-Control-Allow-Headers'  => 'Origin, X-Requested-With, Content-Type, Accept',
                    'Access-Control-Allow-Methods'  => 'POST',
                    'Access-Control-Allow-Origin'   => '*',
                    'Content-Type'                  => 'application/json'
                ],
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'http_errors' => true
            ]
        );

        return $response
            ->getBody()
            ->getContents();
    }
}