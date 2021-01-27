<?php

namespace Tjventurini\GraphQLExceptions\Services;

use Closure;
use Throwable;
use Illuminate\Contracts\Container\BindingResolutionException;

class GraphQLExceptionService
{
    /**
     * Method to handle the exceptions provided by
     * this package.
     *
     * @param  Closure                    $callback $callback The callback to be executed.
     * @return mixed                      Will return whatever the callback returns.
     * @throws BindingResolutionException
     * @throws Throwable
     */
    public function wrap(Closure $callback)
    {
        // call the closure within a try catch block
        //   to catch any exceptions that might occur.
        try {
            return $callback();
        } catch (Throwable $Exception) {
            // if an exception occurs we pass it on
            //   in order to resolve the exception.
            $this->throwException($Exception);
        }
    }

    /**
     * Method to find the right exception to throw and then throw it.
     *
     * @param  Throwable                  $Exception
     * @return void
     * @throws BindingResolutionException
     * @throws Throwable
     */
    public function throwException(Throwable $Exception): void
    {
        // resolve the exception against the exception map
        $GraphQLException = $this->resolveException($Exception);

        // throw the exception we got back
        throw new $GraphQLException($Exception);
    }

    /**
     * Resolve the exception against the exception map
     *
     * @param  Throwable                  $Exception
     * @return String
     * @throws BindingResolutionException
     */
    public function resolveException(Throwable $Exception): String
    {
        // get the exceptions map from the configuration
        $map = collect(config('graphql-exceptions.exception_map', []));

        // if the given exception has a matching candidate
        //   we throw that.
        $ExceptionClass = get_class($Exception);
        if ($map->keys()->contains($ExceptionClass)) {
            // get the exception from the map
            return $map->get($ExceptionClass);
        }

        // if we could not find a matching exception, then
        //   we throw the default exception provided in
        //   the configuration
        return config('graphql-exceptions.default_exception');
    }
}
