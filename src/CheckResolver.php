<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine;

use MSBios\Voting\Doctrine\Resolver\CheckInterface;
use MSBios\Voting\Resource\Doctrine\Entity\PollInterface;
use Zend\Stdlib\PriorityQueue;

/**
 * Class CheckResolver
 * @package MSBios\Voting\Doctrine
 */
class CheckResolver implements CheckResolverInterface
{
    /**
     * @var PriorityQueue|CheckInterface[]
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
     * @return bool
     */
    public function check(PollInterface $poll)
    {
        if (count($this->queue)) {
            /** @var CheckInterface $resolver */
            foreach ($this->queue as $resolver) {
                if ($resource = $resolver->check($poll)) {
                    return $resource;
                }
            }
        }

        return false;
    }

    /**
     * @param CheckInterface $resolver
     * @param int $priority
     * @return $this
     */
    public function attach(CheckInterface $resolver, $priority = 1)
    {
        $this->queue->insert($resolver, $priority);
        return $this;
    }
}
