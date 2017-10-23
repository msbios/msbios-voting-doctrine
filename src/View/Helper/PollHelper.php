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
    /**
     * @param ObjectInterface $option
     * @return Radio
     */
    public function optionElement(ObjectInterface $option)
    {
        return $this->factoryOptionElement(
            $option->getName(),
            $option->getId()
        );
    }

    /**
     * @param ObjectInterface $poll
     * @return \Zend\Form\FormInterface
     */
    public function form(ObjectInterface $poll)
    {
        /** @var FormInterface $formElement */
        $formElement = $this->getFormElement();

        /** @var array $valueOptions */
        $valueOptions = [];

        /** @var array $collection */
        $collection = $poll->getOptions()->toArray();

        usort($collection, [$this, 'sort']);

        /** @var Option $option */
        foreach ($collection as $option) {
            $valueOptions[$option->getId()] = $option->getName();
        }

        $formElement->get('poll_option_identifier')
            ->setValueOptions($valueOptions);

        // add radio values $this->form
        return $formElement;
    }


    /**
     * @param Option $left
     * @param Option $right
     * @return int
     */
    protected function sort(Option $left, Option $right)
    {
        if ($left->getPriority() == $right->getPriority()) {
            return 0;
        }
        return ($left->getPriority() < $right->getPriority()) ? -1 : 1;
    }


}