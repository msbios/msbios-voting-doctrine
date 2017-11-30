<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Doctrine\Controller\Plugin;

use MSBios\Voting\Controller\Plugin\PollPlugin as DefaultPollPlugin;
use MSBios\Voting\PollManagerInterface;
use MSBios\Voting\Resource\Doctrine\Entity\PollInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

/**
 * Class PollPlugin
 * @package MSBios\Voting\Doctrine\Controller\Plugin
 */
class PollPlugin extends AbstractPlugin
{
    /** @var PollManagerInterface */
    protected $pollManager;

    /** @var InputFilterInterface */
    protected $inputFilter;

    /** @var PollInterface */
    protected $current;

    /**
     * PollPlugin constructor.
     * @param PollManagerInterface $pollManager
     * @param InputFilterInterface $inputFilter
     */
    public function __construct(PollManagerInterface $pollManager, InputFilterInterface $inputFilter)
    {
        $this->pollManager = $pollManager;
        $this->inputFilter = $inputFilter;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function setData(array $data)
    {
        $this->inputFilter->setData($data);
        return $this;
    }

    /**
     * @return bool|mixed
     */
    public function vote()
    {
        if ($this->inputFilter->isValid()) {
            /** @var array $data */
            $data = $this->inputFilter->getValues();

            /** @var boolean $result */
            $result = $this->pollManager->vote(
                $data['poll_option_identifier'],
                $data['poll_relation']
            );

            $this->current = $this->pollManager->find(
                $data['poll_identifier'],
                $data['poll_relation']
            );

            return $result;
        }

        return false;
    }

    /**
     * @return PollInterface
     */
    public function current()
    {
        return $this->current;
    }
}
