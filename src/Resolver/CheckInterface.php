<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine\Resolver;

use MSBios\Voting\Resource\Doctrine\Entity\PollInterface;

/**
 * Interface CheckInterface
 * @package MSBios\Voting\Doctrine\Resolver
 */
interface CheckInterface
{
    /**
     * @param PollInterface $poll
     * @return mixed
     */
    public function check(PollInterface $poll);
}
