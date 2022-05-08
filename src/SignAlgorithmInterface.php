<?php

namespace Francerz\JWT;

interface SignAlgorithmInterface
{
    /**
     * Returns the algorithm key identifier
     *
     * @return string
     */
    public function getKey();

    /**
     * Generates token signature with current algorithm.
     *
     * @param string $token
     * @return string
     */
    public function sign($token);
}
