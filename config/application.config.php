<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
return [
    // Retrieve list of modules used in this application.
    'modules' => [
        'MSBios\Paginator\Doctrine',
        'MSBios\Validator',
        'Zend\Serializer',
        'Zend\Db',
        'Zend\I18n',
        'Zend\Navigation',
        'Zend\Cache',
        'Zend\Paginator',
        'Zend\Mvc\Plugin\FilePrg',
        'Zend\Mvc\Plugin\Identity',
        'Zend\Mvc\Plugin\Prg',
        'Zend\Mvc\Plugin\FlashMessenger',
        'Zend\Form',
        'Zend\InputFilter',
        'Zend\Filter',
        'Zend\Hydrator',
        'Zend\Session',
        'Zend\Router',
        'Zend\Validator',

        'DoctrineModule',
        'DoctrineORMModule',

        'MSBios\Cache',
        'MSBios\Hydrator',
        'MSBios\Db',
        'MSBios\Voting\CPanel',
        'MSBios\Test',
        'MSBios\Portal',
        'MSBios\Application',
        'MSBios\Theme',
        'MSBios\Form',
        'MSBios\Assetic',
        'MSBios\View',
        'MSBios\Monolog',
        'MSBios\I18n',
        'MSBios\Widget',
        'MSBios\Resource',
        'MSBios\Navigation',
        'MSBios\Authentication',
        'MSBios\Guard',
        'MSBios\Guard\Resource',
        'MSBios\Guard\CPanel',
        'MSBios\CPanel',
        'MSBios\I18n\Doctrine',
        'MSBios\Guard\Doctrine',
        'MSBios\Portal\Doctrine',
        'MSBios\Doctrine',
        'MSBios\Authentication\Doctrine',
        'MSBios\Guard\CPanel\Doctrine',
        'MSBios\Guard\Resource\Doctrine',
        'MSBios\Resource\Doctrine',
        'MSBios\Form\Doctrine',
        'MSBios\CPanel\Doctrine',

        'MSBios\Voting',
        'MSBios\Voting\Doctrine',
        'MSBios\Voting\Resource',
        'MSBios\Voting\Resource\Doctrine',
        'MSBios\Voting\CPanel\Doctrine',
        'MSBios\Voting\I18n\Resource\Doctrine',

        'Zend\Log',
        'ZendDeveloperTools',
    ],
    // These are various options for the listeners attached to the ModuleManager
    'module_listener_options' => [
        // This should be an array of paths in which modules reside.
        // If a string key is provided, the listener will consider that a module
        // namespace, the value of that key the specific path to that module's
        // Module class.
        'module_paths' => [
            './module',
            './vendor',
        ],
        // An array of paths from which to glob configuration files after
        // modules are loaded. These effectively override configuration
        // provided by modules themselves. Paths may use GLOB_BRACE notation.
        'config_glob_paths' => [
            realpath(__DIR__) . '/autoload/{{,*.}global,{,*.}local}.php',
        ],
        // Whether or not to enable a configuration cache.
        // If enabled, the merged configuration will be cached and used in
        // subsequent requests.
        'config_cache_enabled' => false,
        // The key used to create the configuration cache file name.
        'config_cache_key' => 'application.config.cache',
        // Whether or not to enable a module class map cache.
        // If enabled, creates a module class map cache which will be used
        // by in future requests, to reduce the autoloading process.
        'module_map_cache_enabled' => false,
        // The key used to create the class map cache file name.
        'module_map_cache_key' => 'application.module.cache',
        // The path in which to cache merged configuration.
        'cache_dir' => 'data/cache/',
        // Whether or not to enable modules dependency checking.
        // Enabled by default, prevents usage of modules that depend on other modules
        // that weren't loaded.
        // 'check_dependencies' => true,
    ],
    // Used to create an own service manager. May contain one or more child arrays.
    // 'service_listener_options' => [
    //     [
    //         'service_manager' => $stringServiceManagerName,
    //         'config_key'      => $stringConfigKey,
    //         'interface'       => $stringOptionalInterface,
    //         'method'          => $stringRequiredMethodName,
    //     ],
    // ],
    // Initial configuration with which to seed the ServiceManager.
    // Should be compatible with Zend\ServiceManager\Config.
    // 'service_manager' => [],
];
