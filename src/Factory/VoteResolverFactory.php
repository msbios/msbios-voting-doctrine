<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine\Factory;

use Interop\Container\ContainerInterface;
use MSBios\Voting\Doctrine\Exception\ResolverServiceException;
use MSBios\Voting\Doctrine\VoteResolver;
use MSBios\Voting\Doctrine\VoteResolverInterface;
use MSBios\Voting\Module;
use Zend\Config\Config;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class VoteResolverFactory
 * @package MSBios\Voting\Doctrine\Factory
 */
class VoteResolverFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return VoteResolver|VoteResolverInterface
     * @throws ResolverServiceException
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var VoteResolverInterface $resolverManager */
        $resolverManager = new VoteResolver;

        /** @var Config $options */
        $options = $container->get(Module::class);

        /**
         * @var string $resolver
         * @var int $priority
         */
        foreach ($options->get('vote_resolvers') as $resolver => $priority) {
            if (! $container->has($resolver)) {
                throw new ResolverServiceException('Resolver Service is not found in Service Locator.');
            }
            $resolverManager->attach($container->get($resolver), $priority);
        }

        return $resolverManager;
    }
}
