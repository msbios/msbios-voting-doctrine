<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Doctrine\Factory;

use Interop\Container\ContainerInterface;
use MSBios\Voting\Doctrine\CheckResolver;
use MSBios\Voting\Doctrine\CheckResolverInterface;
use MSBios\Voting\Doctrine\Exception\ResolverServiceException;
use MSBios\Voting\Module;
use Zend\Config\Config;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class CheckResolverFactory
 * @package MSBios\Voting\Doctrine\Factory
 */
class CheckResolverFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return CheckResolver|CheckResolverInterface
     * @throws ResolverServiceException
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var CheckResolverInterface $resolverManager */
        $resolverManager = new CheckResolver;

        /** @var Config $options */
        $options = $container->get(Module::class);

        /**
         * @var string $resolver
         * @var int $priority
         */
        foreach ($options->get('check_resolvers') as $resolver => $priority) {
            if (!$container->has($resolver)) {
                throw new ResolverServiceException("Resolver '{$resolver}' Service is not found in Service Locator.");
            }
            $resolverManager->attach($container->get($resolver), $priority);
        }

        return $resolverManager;
    }
}
