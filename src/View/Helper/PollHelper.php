<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine\View\Helper;

use MSBios\Stdlib\ObjectInterface;
use MSBios\Voting\Doctrine\Form\PollForm;
use MSBios\Voting\PollManagerInterface;
use Zend\Form\FormInterface;
use Zend\View\Helper\AbstractHelper;

/**
 * Class PollHelper
 * @package MSBios\Voting\Doctrine\View\Helper
 */
class PollHelper extends AbstractHelper
{
    /** @var PollManagerInterface  */
    protected $pollManager;

    /** @var PollForm */
    protected $formElement;

    /**
     * PollHelper constructor.
     * @param PollManagerInterface $pollManager
     * @param PollForm $formElement
     */
    public function __construct(PollManagerInterface $pollManager, PollForm $formElement)
    {
        $this->pollManager = $pollManager;
        $this->formElement = $formElement;
    }

    /**
     * @return $this
     */
    public function __invoke()
    {
        return $this;
    }

    /**
     * @param $id
     * @param null $relation
     * @return \MSBios\Stdlib\ObjectInterface
     */
    public function find($id, $relation = null)
    {
        $this->formElement->setData([
            'poll_identifier' => $id,
            'poll_relation' => $relation
        ]);

        return $this->pollManager->find($id, $relation);
    }

    /**
     * @return FormInterface
     */
    public function form()
    {
        return $this->formElement;
    }

    /**
     * @param ObjectInterface $poll
     * @return mixed
     */
    public function isVoted(ObjectInterface $poll)
    {
        return $this->pollManager->isVoted($poll);
    }

    /**
     * @param ObjectInterface $poll
     * @return mixed
     */
    public function votes(ObjectInterface $poll)
    {
        return $this->pollManager->votes($poll);
    }
}
