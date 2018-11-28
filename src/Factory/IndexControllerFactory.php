<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Doctrine\Factory;

use Interop\Container\ContainerInterface;
use MSBios\Voting\Doctrine\Controller\IndexController;
use MSBios\Voting\Form\PollForm;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class IndexControllerFactory
 * @package MSBios\Voting\Doctrine\Factory
 */
class IndexControllerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return IndexController|object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new IndexController($container->get('FormElementManager')->get(PollForm::class));
    }
}
