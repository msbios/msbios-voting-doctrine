<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Doctrine\Factory;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use MSBios\Voting\Doctrine\PollManager;
use MSBios\Voting\Doctrine\Provider\PollProvider;
use MSBios\Voting\Doctrine\Provider\VoteProvider;
use MSBios\Voting\Doctrine\VoteManager;
use MSBios\Voting\Module;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class PollProviderFactory
 * @package MSBios\Voting\Doctrine\Factory
 */
class PollProviderFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return PollProvider|object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new PollProvider($container->get(EntityManager::class));
    }
}
