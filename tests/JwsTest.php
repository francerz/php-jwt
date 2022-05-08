<?php

use Francerz\JWT\JWS;
use Francerz\JWT\Payload;
use Francerz\JWT\RawPayload;
use PHPUnit\Framework\TestCase;

class JwsTest extends TestCase
{
    public function testRawNone()
    {
        $jws = new JWS(new RawPayload('Hello World!'));
        $this->assertEquals(
            'eyJhbGciOiJub25lIiwidHlwIjoiSldUIn0.SGVsbG8gV29ybGQh.',
            $jws->encode()
        );
    }

    public function testNormalNone()
    {
        $payload = new Payload([
            'sub' => '1234567890',
            'name' => 'John Doe',
            'iat' => 1516239022
        ]);

        $this->assertEquals('1234567890', $payload->getSubjectClaim());
        $this->assertEquals(1516239022, $payload->getIssuedAtClaim());

        $jws = new JWS($payload);
        $this->assertEquals(
            'eyJhbGciOiJub25lIiwidHlwIjoiSldUIn0.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.',
            $jws->encode()
        );
    }

    public function testFromString()
    {
        $jwt = 'eyJhbGciOiJub25lIiwidHlwIjoiSldUIn0.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.';
        $jws = JWS::fromString($jwt);

        $this->assertEquals(['alg' => 'none', 'typ' => 'JWT'], $jws->getHeaders());

        $payload = $jws->getPayload();
    
        $this->assertInstanceOf(Payload::class, $payload);
        if (!$payload instanceof Payload) {
            return;
        }
        $this->assertEquals('1234567890', $payload->getSubjectClaim());
        $this->assertEquals(1516239022, $payload->getIssuedAtClaim());
    }
}
