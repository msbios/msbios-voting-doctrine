<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine\Resolver;

use MSBios\Stdlib\ObjectInterface;

/**
 * Interface CheckInterface
 * @package MSBios\Voting\Doctrine\Resolver
 */
interface CheckInterface
{
    /**
     * @param ObjectInterface $poll
     * @return mixed
     */
    public function check(ObjectInterface $poll);
}
