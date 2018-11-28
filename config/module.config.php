<?php

/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Doctrine;

use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [

    'router' => [
        'routes' => [
            'home' => [
                'child_routes' => [
                    'voting' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => 'voting[/[:redirect]]',
                            'defaults' => [
                                'controller' => Controller\VotingController::class,
                                'action' => 'index',
                                'redirect' => null
                            ],
                            'constraints' => [
                                'redirect' => '[a-zA-Z0-9+/]+={0,2}'
                            ]
                        ],
                    ],
                    'voting-cancel' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => 'voting-cancel/:poll_identifier[/:poll_option_identifier[/:poll_relation[/]]]',
                            'defaults' => [
                                'controller' => Controller\VotingController::class,
                                'action' => 'cancel'
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],

    'controllers' => [
        'factories' => [
            Controller\VotingController::class =>
                Factory\VotingControllerFactory::class,
        ],
    ],

    'service_manager' => [
        'factories' => [
            PollManager::class =>
                Factory\PollManagerFactory::class,
            VoteManager::class =>
                Factory\VoteManagerFactory::class,

            // Providers
            Provider\PollProvider::class =>
                Factory\PollProviderFactory::class,
            Provider\VoteProvider::class =>
                Factory\VoteProviderFactory::class,

            // Resolver Managers
            CheckResolver::class =>
                Factory\CheckResolverFactory::class,
            VoteResolver::class =>
                Factory\VoteResolverFactory::class,

            // Resolvers
            Resolver\CheckCookieResolver::class =>
                InvokableFactory::class,
            Resolver\CheckRepositoryResolver::class =>
                InvokableFactory::class,

            Resolver\VoteCookieResolver::class =>
                InvokableFactory::class,
            Resolver\VoteRepositoryResolver::class =>
                Factory\VoteRepositoryResolverFactory::class
        ],
        'aliases' => [
            \MSBios\Voting\PollManager::class =>
                PollManager::class,
            \MSBios\Voting\VoteManager::class =>
                VoteManager::class
        ],
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
         * Default: MSBios\Voting\Doctrine\Provider\PollProvider
         */
        'poll_provider' => Provider\PollProvider::class,

        /**
         *
         * Expects: string
         * Default: MSBios\Voting\Doctrine\Provider\VoteProvider
         */
        'vote_provider' => Provider\VoteProvider::class,

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
         * Default: [ ... ],
         * Examples: [
         *     Resolver\VoteCookieResolver::class => -100,
         *     Resolver\VoteRepositoryResolver::class => -100
         * ]
         */
        'vote_resolvers' => [
            // ...
        ],

        /**
         *
         * Expects: array
         * Default: [ ... ],
         * Examples: [
         *     Resolver\CheckCookieResolver::class => -100,
         *     Resolver\CheckRepositoryResolver::class => -100
         * ]
         */
        'check_resolvers' => [
            // ...
        ]
    ]
];
