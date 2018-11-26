<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Doctrine\Resolver;

use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use MSBios\Doctrine\ObjectManagerAwareTrait;
use MSBios\Voting\Resource\Record\OptionInterface;
use MSBios\Voting\Resource\Record\PollInterface;
use MSBios\Voting\Resource\Record\RelationInterface;

/**
 * Class VoteCookieResolver
 * @package MSBios\Voting\Doctrine\Resolver
 */
class VoteCookieResolver implements VoteInterface
{
    /**
     * @param PollInterface $poll
     * @return string
     */
    public static function hash(PollInterface $poll)
    {
        return md5($poll->getCode() . md5($poll->getId()));
    }

    /**
     * @param PollInterface $poll
     * @param OptionInterface $option
     * @return mixed|void
     */
    public function vote(PollInterface $poll, OptionInterface $option)
    {
        setcookie(self::hash($poll), 1, time() + 60 * 60 * 24 * 365);
    }

    /**
     * @param PollInterface $poll
     * @param OptionInterface $option
     * @return mixed|void
     */
    public function undo(PollInterface $poll, OptionInterface $option)
    {
        /** @var string $key */
        $key = self::hash($poll);
        if (isset($_COOKIE[$key])) {
            unset($_COOKIE[$key]);
            setcookie($key, null, -1);
        }
    }
}
