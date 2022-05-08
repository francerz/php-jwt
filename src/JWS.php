<?php

namespace Francerz\JWT;

use Francerz\Http\Utils\UriHelper;
use Francerz\JWT\SignAlgorithms\NoneAlgorithm;
use RuntimeException;

class JWS
{
    private $headers = [];
    private $payload;

    /**
     * @param PayloadInterface $payload
     * @param AlgorithmInterface $algorithm
     */
    public function __construct($payload = null, array $headers = [])
    {
        isset($payload) && $this->setPayload($payload);
        $this->setHeaders($headers);
    }

    /**
     * Sets the JWS payload.
     *
     * @param PayloadInterface $payload
     * @return void
     */
    public function setPayload(PayloadInterface $payload)
    {
        $this->payload = $payload;
    }

    public function getPayload()
    {
        return $this->payload;
    }

    private function setHeaders(array $headers)
    {
        foreach ($headers as $n => $v) {
            if (!is_string($n) || empty($n)) {
                continue;
            }
            $this->headers[$n] = $v;
        }
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    private function generateHeaders(SignAlgorithmInterface $algorithm)
    {
        $headers = $this->headers;
        $headers['alg'] = $algorithm->getKey();
        $headers['typ'] = 'JWT';
        return $headers;
    }

    public function encode(?SignAlgorithmInterface $algorithm = null)
    {
        $algorithm = $algorithm ?? NoneAlgorithm::getInstance();
        $token =
            UriHelper::base64Encode(json_encode($this->generateHeaders($algorithm)))
            . '.'
            . UriHelper::base64Encode((string)$this->payload);
        $token .= '.' . UriHelper::base64Encode($algorithm->sign($token));
        return $token;
    }

    public static function fromString(string $string)
    {
        $c = substr_count($string, '.');
        if ($c < 2) {
            throw new RuntimeException('Invalid JWS string.');
        }
        [$headers, $payload, $signature] = explode('.', $string);
        $headers = UriHelper::base64Decode($headers);
        $payload = UriHelper::base64Decode($payload);
        $signature = UriHelper::base64Decode($signature);

        $headers = json_decode($headers, true);
        if (!isset($headers)) {
            throw new RuntimeException('Invalid JWS headers.');
        }

        $claims = json_decode($payload, true);
        $payload = isset($claims) ? new Payload($claims) : new RawPayload($payload);

        return new static($payload, $headers);
    }
}
