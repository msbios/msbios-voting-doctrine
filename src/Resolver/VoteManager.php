<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine\Resolver;

use MSBios\Stdlib\ObjectInterface;
use Zend\Stdlib\PriorityQueue;

/**
 * Class VoteManager
 * @package MSBios\Voting\Doctrine\Resolver
 */
class VoteManager implements VoteManagerInterface
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
     * @param $id
     * @param null $relation
     * @return bool|mixed
     */
    public function write($id, $relation = null)
    {
        if (count($this->queue)) {
            /** @var VoteInterface $resolver */
            foreach ($this->queue as $resolver) {
                if ($resource = $resolver->write($id, $relation)) {
                    return $resource;
                }
            }
        }

        return false;
    }

    /**
     * @param VoteInterface $resolver
     * @param int $priority
     */
    public function attach(VoteInterface $resolver, $priority = 1)
    {
        $this->queue->insert($resolver, $priority);
    }
}
