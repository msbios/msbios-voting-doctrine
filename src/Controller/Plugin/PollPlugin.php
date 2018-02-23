<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Doctrine\Controller\Plugin;

use MSBios\Voting\Controller\Plugin\PollPlugin as DefaultPollPlugin;
use MSBios\Voting\PollManagerAwareInterface;
use MSBios\Voting\PollManagerAwareTrait;
use MSBios\Voting\PollManagerInterface;
use MSBios\Voting\Resource\Doctrine\Entity\PollInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

/**
 * Class PollPlugin
 * @package MSBios\Voting\Doctrine\Controller\Plugin
 */
class PollPlugin extends AbstractPlugin implements PollManagerAwareInterface
{
    use PollManagerAwareTrait;

    /** @var InputFilterInterface */
    protected $inputFilter;

    /** @var PollInterface */
    protected $current;

    /**
     * PollPlugin constructor.
     * @param InputFilterInterface $inputFilter
     */
    public function __construct(InputFilterInterface $inputFilter)
    {
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
            $this->getPollManager()->vote(
                $data['poll_option_identifier'],
                $data['poll_relation']
            );

            $this->current = $this->getPollManager()->find(
                $data['poll_identifier'],
                $data['poll_relation']
            );

            return true;
        }

        return false;
    }

    /**
     * @param $id
     * @param null $relation
     * @return mixed
     */
    public function undo($id, $relation = null)
    {
        return $this->getPollManager()->undo($id, $relation);
    }

    /**
     * @return PollInterface
     */
    public function current()
    {
        return $this->current;
    }
}
