<?php

namespace Admin\Exceptions;

/**
 * Class ApartmentsImportException
 * @package Admin\Exceptions
 */
class ApartmentsImportException extends \Exception
{
    /**
     * Array with strings
     * @var array
     */
    protected $errorsMessages = [];

    /**
     * ApartmentsImportException constructor.
     * @param array $messagesErrors
     */
    public function __construct(array $messagesErrors)
    {
        $this->errorsMessages = $messagesErrors;
        parent::__construct();
    }

    /**
     * Returns array with errors messages
     * @return array
     */
    public function getErrorsMessages(): array
    {
        return $this->errorsMessages;
    }
}
