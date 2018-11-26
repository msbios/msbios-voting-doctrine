<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use MSBios\Doctrine\ObjectManagerAwareTrait;
use MSBios\Voting\Resource\Record\OptionInterface;
use MSBios\Voting\Resource\Record\PollInterface;
use MSBios\Voting\VoteManagerInterface;

/**
 * Class VoteManager
 * @package MSBios\Voting\Doctrine
 */
class VoteManager implements ObjectManagerAwareInterface, VoteManagerInterface
{
    use ObjectManagerAwareTrait;

    /** @var  VoteResolverInterface */
    protected $voteResolver;

    /** @var  CheckResolverInterface */
    protected $checkResolver;

    /**
     * VoteManager constructor.
     * @param ObjectManager $objectManager
     * @param VoteResolverInterface $voteResolver
     * @param CheckResolverInterface $checkResolver
     */
    public function __construct(
        ObjectManager $objectManager,
        VoteResolverInterface $voteResolver,
        CheckResolverInterface $checkResolver
    ) {
        $this->setObjectManager($objectManager);
        $this->voteResolver = $voteResolver;
        $this->checkResolver = $checkResolver;
    }

    /**
     * @param PollInterface $poll
     * @param OptionInterface $option
     * @return mixed
     */
    public function vote(PollInterface $poll, OptionInterface $option)
    {
        return $this
            ->voteResolver
            ->vote($poll, $option);
    }

    /**
     * @param PollInterface $poll
     * @param OptionInterface $option
     */
    public function undo(PollInterface $poll, OptionInterface $option)
    {
        return $this
            ->voteResolver
            ->undo($poll, $option);
    }

    /**
     * @param PollInterface $poll
     * @return mixed
     */
    public function check(PollInterface $poll)
    {
        return $this
            ->checkResolver
            ->check($poll);
    }
}
