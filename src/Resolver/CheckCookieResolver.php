<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine\Resolver;

use MSBios\Voting\Resource\Record\PollInterface;
use MSBios\Voting\Resource\Record\RelationInterface;

/**
 * Class CheckCookieResolver
 * @package MSBios\Voting\Doctrine\Resolver
 */
class CheckCookieResolver implements CheckInterface
{
    /**
     * @param PollInterface $poll
     * @return bool
     */
    public function check(PollInterface $poll)
    {
        return array_key_exists(VoteCookieResolver::hash($poll), $_COOKIE);
    }
}
