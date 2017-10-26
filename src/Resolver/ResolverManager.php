<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine\Resolver;

use Zend\Stdlib\PriorityQueue;

/**
 * Class ResolverManager
 * @package MSBios\Voting\Doctrine\Resolver
 */
class ResolverManager implements ResolverManagerInterface
{
    /**
     * @var PriorityQueue|ResolverInterface[]
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
    public function resolve($value)
    {
        /** @var ResolverInterface $resolver */
        foreach ($this->queue as $resolver) {
            if ($resource = $resolver->resolve($value)) {
                return $resource;
            }
        }

        return null;
    }

    /**
     * @param ResolverInterface $resolver
     * @param int $priority
     */
    public function attach(ResolverInterface $resolver, $priority = 1)
    {
        $this->queue->insert($resolver, $priority);
    }
}
