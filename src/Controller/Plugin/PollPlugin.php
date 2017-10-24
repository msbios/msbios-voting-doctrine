<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Doctrine\Controller\Plugin;

use MSBios\Voting\Controller\Plugin\PollPlugin as DefaultPollPlugin;
use MSBios\Voting\PollForm;
use Zend\InputFilter\InputFilterInterface;

/**
 * Class PollPlugin
 * @package MSBios\Voting\Doctrine\Controller\Plugin
 */
class PollPlugin extends DefaultPollPlugin
{
    /**
     * @param array $data
     */
    public function setValue(array $data)
    {
        /** @var InputFilterInterface $inputFilter */
        $inputFilter = $this->getInputFilter();

        /** @var PollForm $formElement */
        $formElement = $this->getFormElement();

        if ($formElement->setData($data)->isValid()) {
        } else {
            r($formElement->getMessages());
            die();
        }

        // if ($inputFilter->setData($data)->isValid()) {
        //    /** @var array $values */
        //    $values = $inputFilter->getValues();
        //
        //     r($values); die();
        //     $this->pollManager->vote();
        // }
    }

    ///**
    // * @return \Zend\InputFilter\InputFilterInterface
    // */
    //protected function getInputFilter()
    //{
    //    /** @var InputFilterFactory $factory */
    //    return (new InputFilterFactory)->createInputFilter([
    //        'poll_identifier' => [
    //            'name' => 'poll_identifier',
    //            'required' => true,
    //        ],
    //        'poll_relation' => [
    //            'name' => 'poll_relation',
    //            'required' => false,
    //        ],
    //        'poll_option_identifier' => [
    //            'name' => 'poll_option_identifier',
    //            'required' => true,
    //        ]
    //    ]);
    //}
}
