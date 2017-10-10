<?php namespace Syscover\Ups;

abstract class Ups {

    protected $user;
    protected $password;
    protected $accessKey;
    const PRODUCTION_ENDPOINT = 'https://onlinetools.ups.com/';
    const SANDBOX_ENDPOINT = 'https://wwwcie.ups.com/';

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
}