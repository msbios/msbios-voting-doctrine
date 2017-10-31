<?php

/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Doctrine;

use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'service_manager' => [
        'factories' => [
            PollManager::class =>
                Factory\PollManagerFactory::class,

            // Providers
            Provider\Poll\RelationProvider::class =>
                InvokableFactory::class,

            // Resolvers
            Resolver\VoteManager::class =>
                Factory\VoteManagerFactory::class,
            Resolver\CheckManager::class =>
                Factory\CheckManagerFactory::class,

            Resolver\Voter\CookieVoter::class =>
                InvokableFactory::class,
            Resolver\Voter\RepositoryVoter::class =>
                InvokableFactory::class,
            Resolver\Checker\CookieChecker::class =>
                InvokableFactory::class,
            Resolver\Checker\RepositoryChecker::class =>
                InvokableFactory::class
        ],
        'aliases' => [
            \MSBios\Voting\PollManager::class =>
                PollManager::class,
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
    ],

    \MSBios\Voting\Module::class => [

        /**
         *
         * Expects: string
         * Default: MSBios\Voting\Doctrine\Provider\Poll\RelationProvider
         */
        'poll_provider' => Provider\Poll\RelationProvider::class,

        /**
         *
         * Expects: string
         * Default: MSBios\Voting\Doctrine\CheckManager
         */
        'vote_manager' => Resolver\VoteManager::class,

        /**
         *
         * Expects: string
         * Default: MSBios\Voting\Doctrine\CheckManager
         */
        'check_manager' => Resolver\CheckManager::class,

        /**
         *
         * Expects: array
         * Default: [
         *     Resolver\Voter\RepositoryVoter::class => -100
         * ]
         */
        'vote_resolvers' => [
            Resolver\Voter\RepositoryVoter::class => -100
        ],

        /**
         *
         * Expects: array
         * Default: [
         *     Resolver\Checker\RepositoryChecker::class => -100
         * ]
         */
        'check_resolvers' => [
            Resolver\Checker\RepositoryChecker::class => -100
        ]
    ]
];
