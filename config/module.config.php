<?php

/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Doctrine;

use MSBios\Voting\Initializer\PollManagerInitializer;
use MSBios\Voting\Initializer\VoteManagerInitializer;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'service_manager' => [
        'factories' => [
            PollManager::class =>
                Factory\PollManagerFactory::class,
            VoteManager::class =>
                Factory\VoteManagerFactory::class,

            // Providers
            Provider\PollProvider::class =>
                InvokableFactory::class,

            // Resolver Managers
            CheckResolver::class =>
                Factory\CheckResolverFactory::class,
            VoteResolver::class =>
                Factory\VoteResolverFactory::class,

            // Resolvers
            Resolver\CheckRepositoryResolver::class =>
                InvokableFactory::class,
            Resolver\VoteRepositoryResolver::class =>
                InvokableFactory::class
        ],
        'aliases' => [
            \MSBios\Voting\PollManager::class =>
                PollManager::class,
            \MSBios\Voting\VoteManager::class =>
                VoteManager::class
        ],
        'initializers' => [
            new VoteManagerInitializer
        ]
    ],

    'controller_plugins' => [
        'factories' => [
            Controller\Plugin\PollPlugin::class =>
                Factory\PollPluginFactory::class,
        ],
        'aliases' => [
            'poll' => Controller\Plugin\PollPlugin::class
        ]
    ],

    'form_elements' => [
        'factories' => [
            Form\PollForm::class =>
                InvokableFactory::class
        ],
        'aliases' => [
            PollManager::class =>
                Form\PollForm::class,
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
        'initializers' => [
            new PollManagerInitializer
        ]
    ],

    \MSBios\Voting\Module::class => [

        /**
         *
         * Expects: string
         * Default: MSBios\Voting\Doctrine\Provider\PollProvider
         */
        'poll_provider' => Provider\PollProvider::class,

        /**
         *
         * Expects: string
         * Default: MSBios\Voting\Doctrine\VoteResolver
         */
        'vote_resolver' => VoteResolver::class,

        /**
         *
         * Expects: string
         * Default: MSBios\Voting\Doctrine\CheckResolver
         */
        'check_resolver' => CheckResolver::class,

        /**
         *
         * Expects: array
         * Default: [
         *     Resolver\VoteRepositoryResolver::class => -100
         * ]
         */
        'vote_resolvers' => [
            // Resolver\VoteRepositoryResolver::class => -100
        ],

        /**
         *
         * Expects: array
         * Default: [
         *     Resolver\CheckRepositoryResolver::class => -100
         * ]
         */
        'check_resolvers' => [
            // Resolver\CheckRepositoryResolver::class => -100
        ]
    ]
];
