<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine\Resolver;

use MSBios\Stdlib\ObjectInterface;
use Zend\Stdlib\PriorityQueue;

/**
 * Class CheckManager
 * @package MSBios\Voting\Doctrine\Resolver
 */
class CheckManager implements CheckManagerInterface
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
     * @param $value
     * @return mixed|null
     */
    public function check(ObjectInterface $poll)
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
     */
    public function attach(CheckInterface $resolver, $priority = 1)
    {
        $this->queue->insert($resolver, $priority);
    }
}
