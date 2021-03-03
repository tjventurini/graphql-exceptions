<?php

namespace Tjventurini\GraphQLExceptions\Tests;

use Exception;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\MultipleRecordsFoundException;
use Tjventurini\GraphQLExceptions\Facades\GraphQLExceptions;
use Tjventurini\GraphQLExceptions\Exceptions\ClientSaveQueryGraphQLException;
use Tjventurini\GraphQLExceptions\Exceptions\ClientSaveInternalGraphQLException;
use Tjventurini\GraphQLExceptions\Exceptions\ClientSaveValidationGraphQLException;
use Tjventurini\GraphQLExceptions\Exceptions\ClientSaveModelNotFoundGraphQLException;
use Tjventurini\GraphQLExceptions\Exceptions\ClientSaveAuthenticationGraphQLException;
use Tjventurini\GraphQLExceptions\Exceptions\ClientSaveMultipleRecordsFoundExceptionGraphQLException;

class ExceptionsTest extends TestCase
{
    /**
     * Test that we catch the internal exception.
     *
     * @return void
     */
    public function test_internal_exception(): void
    {
        $this->expectException(ClientSaveInternalGraphQLException::class);

        GraphQLExceptions::wrap(function () {
            throw new Exception('internal exception test');
        });
    }

    /**
     * Test that we catch the validation exception.
     *
     * @return void
     */
    public function test_validation_exception(): void
    {
        $this->expectException(ClientSaveValidationGraphQLException::class);

        GraphQLExceptions::wrap(function () {
            // create validator that will fail
            $Validator = Validator::make(['foo' => 'bar'], ['foo' => 'in:baz']);

            // throw validation exception for failing validator
            if ($Validator->fails()) {
                throw new ValidationException($Validator);
            };
        });
    }

    /**
     * Test that we catch the authentication exception.
     *
     * @return void
     */
    public function test_authentication_exception(): void
    {
        $this->expectException(ClientSaveAuthenticationGraphQLException::class);

        GraphQLExceptions::wrap(function () {
            throw new AuthenticationException();
        });
    }

    /**
     * Test that we catch the query exception.
     *
     * @return void
     */
    public function test_query_exception(): void
    {
        $this->expectException(ClientSaveQueryGraphQLException::class);

        GraphQLExceptions::wrap(function () {
            DB::select('select * from foo_table where bar = "baz"');
        });
    }

    /**
     * Test that we catch the multiple records found exception.
     *
     * @return void
     */
    public function test_model_not_found_exception(): void
    {
        $this->expectException(ClientSaveModelNotFoundGraphQLException::class);

        GraphQLExceptions::wrap(function () {
            User::findOrFail(999999999999);
        });
    }

    /**
     * Test that we catch the multiple records found exception.
     *
     * @return void
     */
    public function test_multiple_records_found_exception(): void
    {
        $this->expectException(ClientSaveMultipleRecordsFoundExceptionGraphQLException::class);

        GraphQLExceptions::wrap(function () {
            throw new MultipleRecordsFoundException('test multiple records found');
        });
    }
}
