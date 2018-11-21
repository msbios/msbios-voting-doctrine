<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Doctrine\Controller;

/**
 * Class VotingController
 * @package MSBios\Voting\Doctrine\Controller
 */
class VotingController extends \MSBios\Application\Controller\IndexController
{
    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        if ($this->getRequest()->isPost()) {
            
        }

        echo __METHOD__; die();
        return parent::indexAction();
    }

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function cancelAction()
    {
        echo __METHOD__; die();
        return parent::indexAction();
    }
}