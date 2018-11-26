<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine\View\Helper;

use MSBios\Voting\Doctrine\Form\PollForm;
use MSBios\Voting\Doctrine\PollManager;
use MSBios\Voting\PollManagerAwareInterface;
use MSBios\Voting\PollManagerAwareTrait;
use MSBios\Voting\Resource\Record\PollInterface;
use Zend\Form\FormInterface;
use Zend\View\Helper\AbstractHelper;

/**
 * Class PollHelper
 * @package MSBios\Voting\Doctrine\View\Helper
 */
class PollHelper extends AbstractHelper implements PollManagerAwareInterface
{
    use PollManagerAwareTrait;

    /** @var PollForm */
    protected $formElement;

    /**
     * PollHelper constructor.
     * @param PollManager $pollManager
     * @param PollForm $formElement
     */
    public function __construct(PollManager $pollManager, PollForm $formElement)
    {
        $this->setPollManager($pollManager);
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
     * @param $idOrCode
     * @param null $relation
     * @return PollInterface
     */
    public function find($idOrCode, $relation = null)
    {
        $this->formElement->setData([
            'poll_identifier' => $idOrCode,
            'poll_relation' => $relation
        ]);

        return $this->getPollManager()->find($idOrCode, $relation);
    }

    /**
     * @return FormInterface
     */
    public function form()
    {
        return $this->formElement;
    }

    /**
     * @param PollInterface $poll
     * @return mixed
     */
    public function check(PollInterface $poll)
    {
        return $this->getPollManager()->check($poll);
    }

    /**
     * @param PollInterface $poll
     * @return mixed
     */
    public function votes(PollInterface $poll)
    {
        return $this->getPollManager()->votes($poll);
    }
}
