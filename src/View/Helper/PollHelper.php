<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine\View\Helper;

use MSBios\Voting\Doctrine\PollManager;
use MSBios\Voting\PollManagerAwareInterface;
use MSBios\Voting\PollManagerAwareTrait;
use Zend\View\Helper\AbstractHelper;

/**
 * Class PollHelper
 * @package MSBios\Voting\Doctrine\View\Helper
 */
class PollHelper extends AbstractHelper implements PollManagerAwareInterface
{
    use PollManagerAwareTrait;

    /**
     * PollHelper constructor.
     * @param PollManager $pollManager
     */
    public function __construct(PollManager $pollManager)
    {
        $this->setPollManager($pollManager);
    }

    /**
     * @return \MSBios\Voting\PollManagerInterface
     */
    public function __invoke()
    {
        return $this->getPollManager();
    }

    // /**
    //  * @param $idOrCode
    //  * @param null $relation
    //  * @return mixed
    //  */
    // public function find($idOrCode, $relation = null)
    // {
    //     // $this->formElement->setData([
    //     //     'poll_identifier' => $idOrCode,
    //     //     'poll_relation' => $relation
    //     // ]);
    //
    //     return $this->getPollManager()->find($idOrCode, $relation);
    // }
    //
    // /**
    //  * @return FormInterface
    //  */
    // public function form()
    // {
    //     return $this->formElement;
    // }
    //
    // /**
    //  * @param PollInterface $poll
    //  * @return mixed
    //  */
    // public function check(PollInterface $poll)
    // {
    //     return $this->getPollManager()->check($poll);
    // }
    //
    // /**
    //  * @param PollInterface $poll
    //  * @return mixed
    //  */
    // public function variants(PollInterface $poll)
    // {
    //     return $this->getPollManager()->variants($poll);
    // }
}
