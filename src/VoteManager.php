<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Doctrine;

use MSBios\Voting\Resource\Doctrine\Entity\OptionInterface;
use MSBios\Voting\Resource\Doctrine\Entity\PollInterface;
use MSBios\Voting\VoteManagerInterface;

/**
 * Class VoteManager
 * @package MSBios\Voting\Doctrine
 */
class VoteManager implements VoteManagerInterface
{
    /** @var  VoteResolverInterface */
    protected $voteResolver;

    /** @var  CheckResolverInterface */
    protected $checkResolver;

    /**
     * VoteManager constructor.
     * @param VoteResolverInterface $voteResolver
     * @param CheckResolverInterface $checkResolver
     */
    public function __construct(VoteResolverInterface $voteResolver, CheckResolverInterface $checkResolver)
    {
        $this->voteResolver = $voteResolver;
        $this->checkResolver = $checkResolver;
    }

    /**
     * @param OptionInterface $option
     * @param null $relation
     * @return mixed
     */
    public function vote(OptionInterface $option, $relation = null)
    {
        return $this->voteResolver->vote($option, $relation);
    }

    /**
     * @param PollInterface $poll
     * @return mixed
     */
    public function check(PollInterface $poll)
    {
        return $this->checkResolver->check($poll);
    }

    /**
     * @param OptionInterface $option
     * @param null $relation
     * @return mixed
     */
    public function undo(OptionInterface $option, $relation = null)
    {
        return $this->voteResolver->undo($option, $relation);
    }
}
