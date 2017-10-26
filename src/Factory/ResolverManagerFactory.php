<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine\Factory;

use Interop\Container\ContainerInterface;
use MSBios\Voting\Doctrine\ResolverManager;
use MSBios\Voting\Doctrine\ResolverManagerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class ResolverManagerFactory
 * @package MSBios\Voting\Doctrine\Factory
 */
class ResolverManagerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return ResolverManager|ResolverManagerInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var ResolverManagerInterface $resolverManager */
        $resolverManager = new ResolverManager;



        return $resolverManager;
    }
}
