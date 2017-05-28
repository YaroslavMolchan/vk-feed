<?php

namespace App\Helpers\ChainPattern;

abstract class Handler {
    /**
     * @var Handler
     */
    private $successor = null;

    /**
     * Sets a successor handler,
     * in case the class is not able to satisfy the request.
     *
     * @param Handler $handler
     */
    final public function setSuccessor(Handler $handler)
    {
        if ($this->successor === null) {
            $this->successor = $handler;
        } else {
            $this->successor->setSuccessor($handler);
        }
    }

    /**
     * Handles the request or redirect the request
     * to the successor, if the process response is null.
     *
     * @param array $data
     *
     * @return array
     */
    final public function handle(array $data)
    {
        $response = $this->process($data);
        if (($response === null) && ($this->successor !== null)) {
            $response = $this->successor->handle($data);
        }

        return $response;
    }

    /**
     * Processes the request.
     * This is the only method a child can implements,
     * with the constraint to return null to dispatch the request to next successor.
     *
     * @param array $data
     *
     * @return null|mixed
     */
    abstract protected function process(array $data);
}