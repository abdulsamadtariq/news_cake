<?php
namespace App\Message;

class FetchNewsMessage
{
    private $source;
    public function __construct($source)
    {
        $this->source=$source;
    }

    public function getSource(): string
    {
        return $this->source;
    }
}