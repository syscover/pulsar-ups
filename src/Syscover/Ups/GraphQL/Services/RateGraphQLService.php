<?php namespace Syscover\Ups\GraphQL\Services;

use Syscover\Ups\Services\RateService;

class RateGraphQLService
{
    public function resolveRate($root, array $args)
    {
        return RateService::getRate($args['payload']);
    }
}
