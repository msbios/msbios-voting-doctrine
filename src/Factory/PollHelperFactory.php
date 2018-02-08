<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine\Factory;

use Interop\Container\ContainerInterface;
use MSBios\Voting\Doctrine\Form\PollForm;
use MSBios\Voting\Doctrine\View\Helper\PollHelper;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class PollHelperFactory
 * @package MSBios\Voting\Doctrine\Factory
 */
class PollHelperFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return PollHelper
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new PollHelper(
            $container->get('FormElementManager')->get(PollForm::class)
        );
    }
}
