<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine\Factory;

use Interop\Container\ContainerInterface;
use MSBios\Voting\Doctrine\Controller\Plugin\PollPlugin;
use MSBios\Voting\Doctrine\PollManager;
use MSBios\Voting\InputFilter\PollInputFilter;
use MSBios\Voting\Module;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class PollPluginFactory
 * @package MSBios\Voting\Doctrine\Factory
 */
class PollPluginFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return PollPlugin
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new PollPlugin(
            $container->get(PollManager::class),
            $container->get('InputFilterManager')->get(PollInputFilter::class)
        );
    }
}
