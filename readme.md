# UPS package to Laravel

<a href="https://packagist.org/packages/syscover/pulsar-ups"><img src="https://poser.pugx.org/syscover/pulsar-ups/downloads" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/syscover/pulsar-ups"><img src="https://poser.pugx.org/syscover/pulsar-ups/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/syscover/pulsar-ups"><img src="https://poser.pugx.org/syscover/pulsar-ups/license.svg" alt="License"></a>

## Installation

**1 - From the command line run**
```
composer require syscover/pulsar-ups
```

**2 - Execute publish command**
```
php artisan vendor:publish --provider="Syscover\Ups\UpsServiceProvider"
```

**3 - Add graphQL routes to routes/graphql/schema.graphql file**
```
# Ups types
#import ./../../vendor/syscover/pulsar-ups/src/Syscover/Ups/GraphQL/inputs.graphql
#import ./../../vendor/syscover/pulsar-ups/src/Syscover/Ups/GraphQL/types.graphql

# Ups queries
#import ./../../vendor/syscover/pulsar-ups/src/Syscover/Ups/GraphQL/queries.graphql

# Ups mutations
#import ./../../vendor/syscover/pulsar-ups/src/Syscover/Ups/GraphQL/mutations.graphql
```