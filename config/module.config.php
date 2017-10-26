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

            Provider\Poll\RelationProvider::class =>
                InvokableFactory::class,
            Provider\Vote\RelationProvider::class =>
                InvokableFactory::class,
            Resolver\ResolverManager::class =>
                Factory\ResolverManagerFactory::class,

            // Resolvers
            Resolver\CookieResolver::class =>
                InvokableFactory::class,
            Resolver\DatabaseResolver::class =>
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
         * Default: MSBios\Voting\Doctrine\Provider\Vote\RelationProvider
         */
        'vote_provider' => Provider\Vote\RelationProvider::class,

        /**
         *
         * Expects: string
         * Default: MSBios\Voting\Doctrine\ResolverManager
         */
        'resolver_manager' => Resolver\ResolverManager::class,

        /**
         *
         * Expects: array
         * Default: []
         */
        'resolvers' => [
            Resolver\CookieResolver::class => 100,
            Resolver\DatabaseResolver::class => -100
        ]
    ]
];
