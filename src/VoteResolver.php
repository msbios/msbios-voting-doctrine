<?php
/**
 * @access protected
 */

namespace MSBios\Voting\Doctrine;

use MSBios\Voting\Doctrine\Resolver\VoteInterface;
use MSBios\Voting\Resource\Doctrine\Entity\OptionInterface;
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
     * @param OptionInterface $option
     * @param null $relation
     * @return mixed
     */
    public function vote(OptionInterface $option, $relation = null)
    {
        if (count($this->queue)) {
            /** @var VoteInterface $resolver */
            foreach ($this->queue as $resolver) {
                if ($resource = $resolver->vote($option, $relation)) {
                    return $resource;
                }
            }
        }
    }

    /**
     * @param OptionInterface $option
     * @param null $relation
     */
    public function undo(OptionInterface $option, $relation = null)
    {
        // TODO: Implement undo() method.
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
