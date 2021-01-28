<?php

namespace Tjventurini\GraphQLExceptions\Exceptions;

use Exception;
use Illuminate\Database\QueryException;
use Nuwave\Lighthouse\Exceptions\RendersErrorsExtensions;

class ClientSaveQueryGraphQLException extends Exception implements RendersErrorsExtensions
{
    /**
    * @var string
    */
    protected $reason;

    /**
     * @var string
     */
    protected $sql;

    /**
     * @var string
     */
    protected $code;

    /**
     * Constructor of this exception.
     *
     * @param  Illuminate\Database\QueryException $Exception
     * @return void
     */
    public function __construct(QueryException $Exception)
    {
        // pass general error message, code and previous exception to Exception constructor.
        parent::__construct(trans('graphql-exceptions::errors.database_query'));

        // save the real error message as reason
        $this->reason = $Exception->getMessage();

        // save the sql query
        $this->sql = $Exception->getSql();

        // save error code for further investigations
        $this->code = $Exception->getCode();
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
        return 'database';
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
            'reason'  => $this->reason,
            'sql'     => $this->sql,
            'code'    => $this->code,
        ];
    }
}

