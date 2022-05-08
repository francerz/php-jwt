<?php

namespace Francerz\JWT;

class RawPayload implements PayloadInterface
{
    /** @var string|null */
    private $content;

    /**
     * @param string|null $content
     */
    public function __construct($content = null)
    {
        $this->setContent($content);
    }

    /**
     * @param string|null $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function __toString()
    {
        return $this->content ?? '';
    }
}
