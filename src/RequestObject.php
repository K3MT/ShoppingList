<?php

class RequestObject
{
    public $content;
    public $quotify;

    public function __construct($content, $quotify){
            $this->content = $content;
            $this->quotify = $quotify;
    }
}