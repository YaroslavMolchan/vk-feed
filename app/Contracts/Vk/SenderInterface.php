<?php

namespace App\Contracts\Vk;

interface SenderInterface {

    /**
     * @return string
     */
    public function getMethod();

    /**
     * @param string $method
     */
    public function setMethod(string $method);

    /**
     * @return array
     */
    public function getParams();

    /**
     * @param array $params
     */
    public function setParams(array $params);
}