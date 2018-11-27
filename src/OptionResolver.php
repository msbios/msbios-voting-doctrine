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
 * Class OptionResolver
 * @package MSBios\Voting\Doctrine
 */
class OptionResolver
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
     * @param VoteInterface $resolver
     * @param int $priority
     * @return mixed
     */
    public function attach(OptionIn $resolver, $priority = 1)
    {
        $this->queue->insert($resolver, $priority);
        return $this;
    }
}
