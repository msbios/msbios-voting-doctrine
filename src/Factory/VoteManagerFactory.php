<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine\Factory;

use Interop\Container\ContainerInterface;
use MSBios\Voting\Doctrine\Exception\ResolverServiceException;
use MSBios\Voting\Doctrine\Resolver\CheckManager;
use MSBios\Voting\Doctrine\Resolver\CheckManagerInterface;
use MSBios\Voting\Doctrine\Resolver\VoteManager;
use MSBios\Voting\Doctrine\Resolver\VoteManagerInterface;
use MSBios\Voting\Module;
use Zend\Config\Config;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class VoteManagerFactory
 * @package MSBios\Voting\Doctrine\Factory
 */
class VoteManagerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return VoteManager|VoteManagerInterface
     * @throws ResolverServiceException
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var VoteManagerInterface $resolverManager */
        $resolverManager = new VoteManager;

        /** @var Config $options */
        $options = $container->get(Module::class);

        /**
         * @var string $resolver
         * @var int $priority
         */
        foreach ($options->get('vote_resolvers') as $resolver => $priority) {
            if (!$container->has($resolver)) {
                throw new ResolverServiceException('Resolver Service is not found in Service Locator.');
            }
            $resolverManager->attach($container->get($resolver), $priority);
        }

        return $resolverManager;
    }
}
