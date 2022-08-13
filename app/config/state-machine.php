<?php

// dd(StateMachine\Examples\DomainObject::class);

// dd(class_exists(App\Models\User::class));
// dd(class_exists(StateMachine\Examples\DomainObject::class), class_exists(\StateMachine\Examples\DomainObject::class));

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
    ]
);

// return [
//     'graphA' => [
//         // class of your domain object
//         'class' => App\Models\User::class,

//         // name of the graph (default is "default")
//         'graph' => 'graphA',

//         // property of your object holding the actual state (default is "state")
//         'property_path' => 'state',

//         'metadata' => [
//             'title' => 'Graph A',
//         ],

//         // list of all possible states
//         'states' => [
//             // a state as associative array
//             ['name' => 'new'],
//             // a state as associative array with metadata
//             [
//                 'name' => 'pending_review',
//                 'metadata' => ['title' => 'Pending Review'],
//             ],
//             // states as string
//             'awaiting_changes',
//             'accepted',
//             'published',
//             'rejected',
//         ],

//         // list of all possible transitions
//         'transitions' => [
//             'create' => [
//                 'from' => ['new'],
//                 'to' => 'pending_review',
//             ],
//             'ask_for_changes' => [
//                 'from' =>  ['pending_review', 'accepted'],
//                 'to' => 'awaiting_changes',
//                 'metadata' => ['title' => 'Ask for changes'],
//             ],
//             'cancel_changes' => [
//                 'from' => ['awaiting_changes'],
//                 'to' => 'pending_review',
//             ],
//             'submit_changes' => [
//                 'from' => ['awaiting_changes'],
//                 'to' =>  'pending_review',
//             ],
//             'approve' => [
//                 'from' => ['pending_review', 'rejected'],
//                 'to' =>  'accepted',
//             ],
//             'publish' => [
//                 'from' => ['accepted'],
//                 'to' =>  'published',
//             ],
//         ],

//         // list of all callbacks
//         'callbacks' => [
//             // will be called when testing a transition
//             'guard' => [
//                 'guard_on_submitting' => [
//                     // call the callback on a specific transition
//                     'on' => 'submit_changes',
//                     // will call the method of this class
//                     'do' => ['MyClass', 'handle'],
//                     // arguments for the callback
//                     'args' => ['object'],
//                 ],
//                 'guard_on_approving' => [
//                     // call the callback on a specific transition
//                     'on' => 'approve',
//                     // will check the ability on the gate or the class policy
//                     'can' => 'approve',
//                 ],
//             ],

//             // will be called before applying a transition
//             'before' => [],

//             // will be called after applying a transition
//             'after' => [],
//         ],
//     ],
// ];
