<?php

/*
 |--------------------------------------------------------------------------
 | GraphQL Exceptions Configuration
 |--------------------------------------------------------------------------
 |
 | In this configuration file you will find all configuration options
 | that this package has to offer.
 |
*/

return [
    /*
     |--------------------------------------------------------------------------
     | Exception Map
     |--------------------------------------------------------------------------
     |
     | In the following array you can add exceptions to be resolved.
     |
    */

    'exception_map' => [
        Illuminate\Validation\ValidationException::class            => Tjventurini\GraphQLExceptions\Exceptions\ClientSaveValidationGraphQLException::class,
        Illuminate\Database\Eloquent\ModelNotFoundException::class  => Tjventurini\GraphQLExceptions\Exceptions\ClientSaveModelNotFoundGraphQLException::class,
        Illuminate\Auth\AuthenticationException::class              => Tjventurini\GraphQLExceptions\Exceptions\ClientSaveAuthenticationGraphQLException::class,
        Illuminate\Database\QueryException::class                   => Tjventurini\GraphQLExceptions\Exceptions\ClientSaveQueryGraphQLException::class,
        Illuminate\Database\MultipleRecordsFoundException::class    => Tjventurini\GraphQLExceptions\Exceptions\ClientSaveMultipleRecordsFoundExceptionGraphQLException::class,
    ],

    /*
     |--------------------------------------------------------------------------
     | Default Exception
     |--------------------------------------------------------------------------
     |
     | The following exception will be thrown when no matching exception was
     | found in the exception map.
     |
    */

    'default_exception' => Tjventurini\GraphQLExceptions\Exceptions\ClientSaveInternalGraphQLException::class,
];
