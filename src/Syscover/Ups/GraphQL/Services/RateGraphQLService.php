<?php namespace Syscover\Ups\GraphQL\Services;

use Syscover\Ups\Services\RateService;

class RateGraphQLService
{
    protected $service = RateService::class;

    public function resolveRate($root, array $args)
    {
        return RateService::getRate($args['payload']);
    }
}
