<?php namespace Syscover\Ups;

class Tracking extends Ups
{
    const ENDPOINT = '/Track';

    /**
     * @var array
     */
    private $request = [];

    /**
     * @var bool
     */
    private $debug = false;

    public function __construct(
        string $user,
        string $password,
        string $accessKey
    )
    {
        parent::__construct($user, $password, $accessKey);

        $this->addUpsSecurity();
    }

    private function addUpsSecurity()
    {
        $this->request['UPSSecurity']['UsernameToken']['Username'] = $this->user;
        $this->request['UPSSecurity']['UsernameToken']['Password'] = $this->password;
        $this->request['UPSSecurity']['ServiceAccessToken']['AccessLicenseNumber'] = $this->accessKey;

        return $this;
    }

    public function track($trackingNumber, $locale = 'en_US')
    {
        $this->request['TrackRequest']['Request']['RequestOption'] = 'activity';
        $this->request['TrackRequest']['InquiryNumber'] = $trackingNumber;
        $this->request['TrackRequest']['Locale'] = $locale;

        return json_decode($this->send());
    }

    public function request()
    {
        return $this->request;
    }

    public function send()
    {
        $client = new \GuzzleHttp\Client();

        if($this->debug) return response()->json($this->request);

        $response = $client->post(
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

        return $response
            ->getBody()
            ->getContents();
    }
}