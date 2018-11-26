<?php
/**
 * @access protected
 */

namespace MSBios\Voting\Doctrine;

use MSBios\Voting\Doctrine\Resolver\VoteInterface;
use MSBios\Voting\Resource\Record\OptionInterface;
use MSBios\Voting\Resource\Record\PollInterface;
use Zend\Stdlib\PriorityQueue;

/**
 * Class VoteResolver
 * @package MSBios\Voting\Doctrine
 */
class VoteResolver implements VoteResolverInterface
{
    /**
     * @var PriorityQueue|VoteInterface[]
     */
    protected $queue;

    /**
     * Constructor
     *
     * Instantiate the internal priority queue
     */
    public function __construct()
    {
        $this->queue = new PriorityQueue;
    }

    /**
     * @param PollInterface $poll
     * @param OptionInterface $option
     * @return mixed
     */
    public function vote(PollInterface $poll, OptionInterface $option)
    {
        if (count($this->queue)) {
            /** @var VoteInterface $resolver */
            foreach ($this->queue as $resolver) {
                if ($resource = $resolver->vote($poll, $option)) {
                    return $resource;
                }
            }
        }
    }

    /**
     * @param PollInterface $poll
     * @param OptionInterface $option
     * @return mixed
     */
    public function undo(PollInterface $poll, OptionInterface $option)
    {
        if (count($this->queue)) {
            /** @var VoteInterface $resolver */
            foreach ($this->queue as $resolver) {
                if ($resource = $resolver->undo($poll, $option)) {
                    return $resource;
                }
            }
        }
    }

    /**
     * @param VoteInterface $resolver
     * @param int $priority
     * @return mixed
     */
    public function attach(VoteInterface $resolver, $priority = 1)
    {
        $this->queue->insert($resolver, $priority);
        return $this;
    }
}
