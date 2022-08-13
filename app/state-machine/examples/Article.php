<?php

namespace StateMachine\Examples;

/**
 * Article
 */
class Article
{
    public $state;

    public function __construct($state = 'new')
    {
        $this->state = $state;
    }
}