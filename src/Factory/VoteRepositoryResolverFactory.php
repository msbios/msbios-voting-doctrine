<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine\Factory;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use MSBios\Voting\Doctrine\Resolver\VoteRepositoryResolver;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class VoteRepositoryResolverFactory
 * @package MSBios\Voting\Doctrine\Factory
 */
class VoteRepositoryResolverFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return VoteRepositoryResolver|object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new VoteRepositoryResolver($container->get(EntityManager::class));
    }
}
