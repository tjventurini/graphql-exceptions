<?php

namespace Tjventurini\GraphQLExceptions\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Nuwave\Lighthouse\Exceptions\RendersErrorsExtensions;

class ClientSaveValidationGraphQLException extends Exception implements RendersErrorsExtensions
{
    /**
    * @var @string
    */
    protected $reason;

    /**
     * Constructor of this exception.
     *
     * @param Tjventurini\GraphQLExceptions\Exceptions\Throwable $Exception
     * @return void
     */
    public function __construct(ValidationException $Exception)
    {
        // pass general error message, code and previous exception to Exception constructor.
        parent::__construct(trans('graphql-exceptions::errors.validation'), $Exception->getCode(), $Exception);

        // save the real error message as reason
        $this->reason = $Exception->getMessage();

        // save the errors to pass them on to the frontend
        $this->errors = $Exception->errors();
    }

    /**
     * Returns true when exception message is safe to be displayed to a client.
     *
     * @api
     * @return bool
     */
    public function isClientSafe(): bool
    {
        return true;
    }

    /**
     * Returns string describing a category of the error.
     *
     * Value "graphql" is reserved for errors produced by query parsing or validation, do not use it.
     *
     * @api
     * @return string
     */
    public function getCategory(): string
    {
        return 'validation';
    }

    /**
     * Return the content that is put in the "extensions" part
     * of the returned error.
     *
     * @return array
     */
    public function extensionsContent(): array
    {
        return [
            'reason' => $this->reason,
            'errors' => $this->errors
        ];
    }
}
