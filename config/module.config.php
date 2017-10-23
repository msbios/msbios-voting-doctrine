<?php

/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Doctrine;

use MSBios\Voting\PollForm;

return [
    'service_manager' => [
        'factories' => [
            PollManager::class =>
                Factory\PollManagerFactory::class,
        ],
        'aliases' => [
            \MSBios\Voting\PollManager::class =>
                PollManager::class,
        ]
    ],

//    'controller_plugins' => [
//        'factories' => [
//            Controller\Plugin\PollPlugin::class =>
//                InvokableFactory::class,
//        ],
//        'aliases' => [
//            'poll' => Controller\Plugin\PollPlugin::class
//        ]
//    ],

    'form_elements' => [
        'aliases' => [
            View\Helper\PollHelper::class =>
                PollForm::class
        ],
    ],

    'view_helpers' => [
        'factories' => [
            View\Helper\PollHelper::class =>
                Factory\PollHelperFactory::class
        ],
        'aliases' => [
            'poll' => View\Helper\PollHelper::class
        ],
    ],
];
