<?php

/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine;

return [
    'service_manager' => [
        'factories' => [
            \MSBios\Voting\PollManager::class => Factory\PollManagerFactory::class,
        ],
    ],
];
