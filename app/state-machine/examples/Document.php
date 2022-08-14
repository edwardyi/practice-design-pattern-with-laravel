<?php

namespace StateMachine\Examples;

/**
 * Document
 */
class Document
{
    public $state;

    public function __construct($state = 'draft')
    {
        $this->state = $state;
    }
}