<?php

namespace Core\Component\Http;

class Response
{
    private string $content;
    private int $statusCode;

    /**
     * @param string $content
     * @param int $statusCode
     */
    public function __construct(string $content = "", int $statusCode = 200)
    {
        $this->setContent($content);
        $this->setStatusCode($statusCode);
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return Response
     */
    public function setContent(string $content): static
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     * @return Response
     */
    public function setStatusCode(int $statusCode = 200): static
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function send():static
    {
        echo $this->content;
        return $this;
    }
}