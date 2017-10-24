<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine\Factory;

use Interop\Container\ContainerInterface;
use MSBios\Voting\Doctrine\PollForm;
use MSBios\Voting\Module;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class PollFormFactory
 * @package MSBios\Voting\Doctrine\Factory
 */
class PollFormFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return PollForm
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new PollForm(
            $container->get(Module::class)
        );
    }
}
