<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine\Resolver;

use MSBios\Voting\Resource\Doctrine\Entity\PollInterface;

/**
 * Class CheckRepositoryResolver
 * @package MSBios\Voting\Doctrine\Resolver
 */
class CheckRepositoryResolver implements CheckInterface
{
    /**
     * @param PollInterface $poll
     * @return bool
     */
    public function check(PollInterface $poll)
    {
        return false;
    }
}
