<?php

return array(
    'graphA' => [
        'class' => StateMachine\Examples\DomainObject::class,
        'graph'         => 'myGraphA', // Name of the current graph - there can be many of them attached to the same object
        'property_path' => 'stateA',  // Property path of the object actually holding the state
        'states'        => array(
            'checkout',
            'pending',
            'confirmed',
            'cancelled'
        ),
        'transitions' => array(
            'create' => array(
                'from' => array('checkout'),
                'to'   => 'pending'
            ),
            'confirm' => array(
                'from' => array('checkout', 'pending'),
                'to'   => 'confirmed'
            ),
            'cancel' => array(
                'from' => array('confirmed'),
                'to'   => 'cancelled'
            )
        ),
        'callbacks' => array(
            'guard' => array(
                'guard-cancel' => array(
                    'to' => array('cancelled'), // Will be called only for transitions going to this state
                    'do' => function() { var_dump('guarding to cancelled state'); return false; }
                )
            ),
            'before' => array(
                'from-checkout' => array(
                    'from' => array('checkout'), // Will be called only for transitions coming from this state
                    'do'   => function() { var_dump('from checkout transition'); }
                )
            ),
            'after' => array(
                'on-confirm' => array(
                    'on' => array('confirm'), // Will be called only on this transition
                    'do' => function() { var_dump('on confirm transition'); }
                ),
                'to-cancelled' => array(
                    'to' => array('cancelled'), // Will be called only for transitions going to this state
                    'do' => function() { var_dump('to cancel transition'); }
                ),
                'confirm-date' => array(
                    'on' => array('confirm'),
                    'do' => array('object', 'setConfirmedNow'), // 'object' will be replaced by the object undergoing the transition
                ),
            )
        )
    ],
    'article' => [
        'class' => StateMachine\Examples\Article::class,
        'graph'         => 'article', // Name of the current graph - there can be many of them attached to the same object
        'property_path' => 'articleState',  // Property path of the object actually holding the state
        'metadata' => [
            'title' => 'Article State Machine',
        ],

        'states' => [
            [
                'name' => 'pending_review',
                'metadata' => ['title' => 'Pending Review'],
            ],
        ],

        'transitions' => [
            'ask_for_changes' => [
                'from' => ['pending_review'],
                'to' => 'accepted',
                'metadata' => ['title' => 'Ask for changes'],
            ],
        ],
    ]
);