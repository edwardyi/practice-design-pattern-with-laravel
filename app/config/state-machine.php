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
                'name' => 'new',
                'metadata' => ['title' => 'New Article'],
            ],
            [
                'name' => 'pending_review',
                'metadata' => ['title' => 'Pending Review'],
            ],
            [
                'name' => 'published',
                'metadata' => ['title' => 'Published'],
            ],
            [
                'name' => 'accepted',
                'metadata' => ['title' => 'Ask for changes'],
            ]
        ],

        'transitions' => [
            'ask_for_changes' => [
                'from' => ['pending_review'],
                'to' => 'accepted',
                'metadata' => ['title' => 'Ask for changes'],
            ],
            'create' => ['from' => ['new'], 'to' => 'pending_review'],
            'publish' => ['from' => ['pending_review'], 'to' => 'published'],
        ],
    ],
    'document' => [
        'class' => StateMachine\Examples\Document::class,
        'graph'         => 'document', // Name of the current graph - there can be many of them attached to the same object
        'property_path' => 'documentState',  // Property path of the object actually holding the state
        'metadata' => [
            'title' => 'Document State Machine',
        ],

        'states' => [
            [
                'name' => 'draft',
                'metadata' => [
                    'title' => 'Draft'
                ],
            ],
            [
                'name' => 'moderation',
                'metadata' => [
                    'title' => 'Moderation',
                    'description' => 'published_by_user'
                ],
            ],
            [
                'name' => 'published',
                'metadata' => [
                    'title' => 'Published',
                    'description' => 'published_by_admin'
                ],
            ]
        ],
        'transitions' => [
            'published_by_admin' => ['from' => ['draft'], 'to' => 'published'],
            'published_by_user' => ['from' => ['draft'], 'to' => 'moderation'],
            'review_failed' => ['from' => ['moderation'], 'to' => 'draft'],
            'approved_by_admin' => ['from' => ['moderation'], 'to' => 'published'],
            'publication_expired' => ['from' => ['published'], 'to' => 'draft'],
        ],
    ],
    'audio_player' => [
        'class' => StateMachine\Examples\AudioPlayer::class,
        'graph'         => 'audio_player', // Name of the current graph - there can be many of them attached to the same object
        'property_path' => 'AudioPlayerState',  // Property path of the object actually holding the state
        'metadata' => [
            'title' => 'AudioPlayer State Machine',
        ],

        'states' => [
            [
                'name' => 'locked',
                'metadata' => [
                    'title' => 'Locked'
                ],
            ],
            [
                'name' => 'ready',
                'metadata' => [
                    'title' => 'Ready'
                ],
            ],
            [
                'name' => 'playing',
                'metadata' => [
                    'title' => 'Playing'
                ],
            ],
        ],
        'transitions' => [
            'click_lock_when_playing' => ['from' => ['playing'], 'to' => 'locked'],
            'click_lock_when_locked' => ['from' => ['locked'], 'to' => 'ready'],
            'click_play_when_playing' => ['from' => ['playing'], 'to' => 'ready'],
            'click_play_when_ready' => ['from' => ['ready'], 'to' => 'playing'],
            'click_lock_when_ready' => ['from' => ['ready'], 'to' => 'locked'],
        ],
    ]
);