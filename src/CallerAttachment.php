<?php

namespace WendellAdriel\LaravelCaller;

class CallerAttachment
{
    /**
     * @param string          $name
     * @param string|resource $content
     * @param string          $filename
     */
    public function __construct(
        private string $name,
        private $content,
        private string $filename
    ) {
    }

    /**
     * @param string          $name
     * @param string|resource $content
     * @param string          $filename
     * @return CallerAttachment
     */
    public static function make(string $name, $content, string $filename): CallerAttachment
    {
        return new static($name, $content, $filename);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return CallerAttachment
     */
    public function setName(string $name): CallerAttachment
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|resource
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string|resource $content
     * @return CallerAttachment
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     * @return CallerAttachment
     */
    public function setFilename(string $filename): CallerAttachment
    {
        $this->filename = $filename;
        return $this;
    }
}
