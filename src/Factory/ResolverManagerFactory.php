<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine\Factory;

use Interop\Container\ContainerInterface;
use MSBios\Voting\Doctrine\Exception\ResolverServiceException;
use MSBios\Voting\Doctrine\Resolver\ResolverManager;
use MSBios\Voting\Doctrine\Resolver\ResolverManagerInterface;
use MSBios\Voting\Module;
use Zend\Config\Config;
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
     * @throws ResolverServiceException
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var ResolverManagerInterface $resolverManager */
        $resolverManager = new ResolverManager;

        /** @var Config $options */
        $options = $container->get(Module::class);

        /**
         * @var string $resolver
         * @var int $priority
         */
        foreach ($options->get('resolvers') as $resolver => $priority) {
            if (!$container->has($resolver)) {
                throw new ResolverServiceException('Resolver Service is not found in Service Locator.');
            }
            $resolverManager->attach($container->get($resolver), $priority);
        }

        return $resolverManager;
    }
}
