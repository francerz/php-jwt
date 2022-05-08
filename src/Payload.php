<?php

namespace Francerz\JWT;

class Payload implements PayloadInterface
{
    private $claims = [];

    public function __construct(array $claims = [])
    {
        $this->setClaims($claims);
    }

    public function setClaims(array $claims)
    {
        foreach ($claims as $n => $v) {
            if (!is_string($n) || empty($n)) {
                continue;
            }
            $this->claims[$n] = $v;
        }
    }

    public function setClaim(string $name, $value)
    {
        $this->claims[$name] = $value;
    }

    public function getClaim(string $name)
    {
        return $this->claims[$name] ?? null;
    }

    public function setIssuerClaim($value)
    {
        $this->setClaim('iss', $value);
    }

    public function getIssuerClaim()
    {
        return $this->getClaim('iss');
    }

    public function setSubjectClaim(string $value)
    {
        $this->setClaim('sub', $value);
    }

    public function getSubjectClaim()
    {
        return $this->getClaim('sub');
    }

    public function setAudienceClaim(string $value)
    {
        $this->setClaim('aud', $value);
    }

    public function getAudienceClaim()
    {
        return $this->getClaim('aud');
    }

    /**
     * @param int|DateTime|DateTimeImmutable $value
     * @return void
     */
    public function setExpirationTimeClaim($value)
    {
        $this->setClaim('exp', $value);
    }

    public function getExpirationTimeClaim()
    {
        return $this->getClaim('exp');
    }

    /**
     * @param int|DateTime|DateTimeImmutable $value
     * @return void
     */
    public function setNotBeforeClaim($value)
    {
        $this->setClaim('nbf', $value);
    }

    public function getNotBeforeClaim()
    {
        return $this->getClaim('nbf');
    }

    /**
     * @param int|DateTime|DateTimeImmutable $value
     * @return void
     */
    public function setIssuedAtClaim($value)
    {
        $this->setClaim('iat', $value);
    }

    public function getIssuedAtClaim()
    {
        return $this->getClaim('iat');
    }

    public function setJwtIDClaim($value)
    {
        $this->setClaim('jti', $value);
    }

    public function getJwtIDClaim()
    {
        return $this->getClaim('jti');
    }

    public function __toString()
    {
        return json_encode($this->claims);
    }   
}
