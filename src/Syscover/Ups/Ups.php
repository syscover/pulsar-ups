<?php namespace Syscover\Ups;

abstract class Ups
{
    const PRODUCTION_ENDPOINT = 'https://onlinetools.ups.com/';
    const SANDBOX_ENDPOINT = 'https://wwwcie.ups.com/';

    /**
     * @var string
     */
    protected $user;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $accessKey;

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