<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Doctrine\Factory;

use Interop\Container\ContainerInterface;
use MSBios\Voting\Doctrine\Controller\VotingController;
use MSBios\Voting\Doctrine\PollManager;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class VotingControllerFactory
 * @package MSBios\Voting\Doctrine\Factory
 */
class VotingControllerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return VotingController|object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new VotingController($container->get(PollManager::class));
    }
}
