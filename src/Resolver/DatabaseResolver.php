<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine\Resolver;

use MSBios\Stdlib\ObjectInterface;

/**
 * Class DatabaseResolver
 * @package MSBios\Voting\Doctrine\Resolver
 */
class DatabaseResolver implements ResolverInterface
{
    /**
     * @param ObjectInterface $poll
     * @return bool
     */
    public function check(ObjectInterface $poll)
    {
        return false;
    }
}
