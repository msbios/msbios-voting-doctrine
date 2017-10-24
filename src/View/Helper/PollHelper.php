<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Doctrine\View\Helper;

use MSBios\Stdlib\ObjectInterface;
use MSBios\Voting\Resource\Doctrine\Entity\Option;
use MSBios\Voting\View\Helper\PollHelper as DefaultPollHelper;
use Zend\Form\Element\Radio;
use Zend\Form\FormInterface;

/**
 * Class PollHelper
 * @package MSBios\Voting\Doctrine\View\Helper
 */
class PollHelper extends DefaultPollHelper
{
//    /**
//     * @param ObjectInterface $option
//     * @return Radio
//     */
//    public function optionElement(ObjectInterface $option)
//    {
//        //return $this->factoryOptionElement(
//        //    $option->getName(),
//        //    $option->getId()
//        //);
//    }

    /**
     * @param ObjectInterface $poll
     * @return \Zend\Form\FormInterface
     */
    public function form()
    {

        return $this->pollManager->form();

//        /** @var FormInterface $formElement */
//        $formElement = $this->getFormElement();
//        $formElement->getSubmitElement()
//            ->setValue($this->identifier);
//        $formElement->getRelationElement()
//            ->setValue($this->relation);
//
//        /** @var array $valueOptions */
//        $valueOptions = [];
//
//        /** @var array $collection */
//        $collection = $poll->getOptions()->toArray();
//
//        usort($collection, [$this, 'uSortOptions']);
//
//        /** @var Option $option */
//        foreach ($collection as $option) {
//            $valueOptions[$option->getId()] = $option->getName();
//        }
//
//        $formElement->getOptionElement()
//            ->setValueOptions($valueOptions);
//
//        // add radio values $this->form
//        return $formElement;
    }

//    /**
//     * @param Option $left
//     * @param Option $right
//     * @return int
//     */
//    protected function uSortOptions(Option $left, Option $right)
//    {
//        if ($left->getPriority() == $right->getPriority()) {
//            return 0;
//        }
//        return ($left->getPriority() < $right->getPriority()) ? -1 : 1;
//    }
}
