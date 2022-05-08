<?php

namespace Francerz\JWT;

interface PayloadInterface
{
    /**
     * Returns payload in UTF-8 sequenced string
     *
     * @return string
     */
    public function __toString();
}
