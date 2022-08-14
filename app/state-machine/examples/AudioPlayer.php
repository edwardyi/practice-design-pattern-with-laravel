<?php

namespace StateMachine\Examples;

/**
 * AudioPlayer
 */
class AudioPlayer
{
    public $state;

    public function __construct($state = 'draft')
    {
        $this->state = $state;
    }
}