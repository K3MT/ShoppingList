<?php

  namespace App;

    # Request object
    class RequestObject
    {
        public $content;    # The value of the variable
        public $quotify;    # If this is true, then the value is an integer and will not be quoted

        public function __construct($content, $quotify){
                $this->content = $content;
                $this->quotify = $quotify;
        }
    }
?>