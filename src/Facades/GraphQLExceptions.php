<?php

namespace Tjventurini\GraphQLExceptions\Facades;

use Illuminate\Support\Facades\Facade;

class GraphQLExceptions extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'graphql-exceptions-service';
    }
}
