<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine\Factory;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use MSBios\Voting\Doctrine\VoteManager;
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
     * @return VoteManager|object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var Config $options */
        $options = $container->get(Module::class);

        return new VoteManager(
            $container->get(EntityManager::class),
            $container->get($options->get('vote_resolver')),
            $container->get($options->get('check_resolver'))
        );
    }
}
