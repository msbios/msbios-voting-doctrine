<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Doctrine\Controller;

use MSBios\Voting\PollManagerAwareInterface;
use MSBios\Voting\PollManagerAwareTrait;
use MSBios\Voting\PollManagerInterface;
use MSBios\Voting\Resource\Record\PollInterface;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Class VotingController
 * @package MSBios\Voting\Doctrine\Controller
 */
class VotingController extends AbstractActionController
{
    use PollManagerAwareTrait;

    /**
     * VotingController constructor.
     * @param PollManagerInterface $pollManager
     */
    public function __construct(PollManagerInterface $pollManager)
    {
        $this->setPollManager($pollManager);
    }

    /**
     * @return \Zend\Http\Response|\Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        if ($this->getRequest()->isPost()) {
            /** @var array $data */
            $data = $this->params()->fromPost();

            /** @var PollManagerInterface $pollManager */
            $pollManager = $this->getPollManager();

            /** @var PollInterface $poll */
            $poll = $pollManager->find($data['poll_identifier'], $data['poll_relation']);

            if ($poll && ! $pollManager->check($poll)) {
                $pollManager->vote($poll, $data['poll_option_identifier']);
                $this
                    ->flashMessenger()
                    ->addSuccessMessage('Your vote has been successfully processed.');
            }
        }

        return $this
            ->redirect()
            ->toRoute('home');
    }

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function cancelAction()
    {
        /** @var PollManagerInterface $pollManager */
        $pollManager = $this->getPollManager();

        /** @var PollInterface $poll */
        $poll = $pollManager->find(
            $this->params()->fromRoute('poll_identifier'), $this->params()->fromRoute('poll_relation')
        );

        if ($poll) {
            $pollManager->undo($poll, $this->params()->fromRoute('poll_option_identifier'));

            $this
                ->flashMessenger()
                ->addSuccessMessage('Your vote has been successfully canceled.');
        }

        return $this
            ->redirect()
            ->toRoute('home');
    }
}
