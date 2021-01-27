# Graphql Exceptions

Better client save exceptions for the lighthouse-php graphql implementation.

## Installation

```
composer require tjventurini/graphql-exceptions
```

## Usage

The `GraphQLExceptions` facade provides a convenient `wrap` method that accepts a `Closure` that you can use to put your logic in. If a thrown error matches the exceptions provided in the configuration it will resolve it to a client save graphql exception.

```php
use Tjventurini\GraphQLExceptions\Facades\GraphqlExceptions;

GraphQLExceptions::wrap(function() {
    // your logic
});
```

## Configuration

In the `graphql-exceptions` configuration you can define the default exception to throw and an exception map that we use to resolve the thrown exception with a client save exception.

```php
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
```