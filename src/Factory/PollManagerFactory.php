<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine\Factory;

use Interop\Container\ContainerInterface;
use MSBios\Voting\Doctrine\PollManager;
use MSBios\Voting\Module;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class PollManagerFactory
 * @package MSBios\Voting\Doctrine\Factory
 */
class PollManagerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return PollManager
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new PollManager(
            $container->get(Module::class)
        );
    }
}
