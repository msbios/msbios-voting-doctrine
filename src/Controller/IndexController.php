<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Doctrine\Controller;

use MSBios\Voting\Form\PollForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ModelInterface;

/**
 * Class IndexController
 * @package MSBios\Voting\Doctrine\Controller
 */
class IndexController extends AbstractActionController
{

    /** @var PollForm */
    protected $form;

    /**
     * IndexController constructor.
     * @param PollForm $form
     */
    public function __construct(PollForm $form)
    {
        $this->form = $form;
    }

    /**
     * @return ModelInterface|\Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        /** @var ModelInterface $viewManager */
        $viewManager = parent::indexAction();
        $viewManager->setVariable('form', $this->form);
        return $viewManager;
    }
}
