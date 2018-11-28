<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine\Factory;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use MSBios\Voting\Doctrine\Provider\VoteProvider;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class VoteProviderFactory
 * @package MSBios\Voting\Doctrine\Factory
 */
class VoteProviderFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return VoteProvider|object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new VoteProvider($container->get(EntityManager::class));
    }
}
