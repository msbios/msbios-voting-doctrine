<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine\Resolver;

use MSBios\Voting\Resource\Doctrine\Entity\PollInterface;
use MSBios\Voting\Resource\Doctrine\Entity\RelationInterface;

/**
 * Class CookieChecker
 * @package MSBios\Voting\Doctrine\Resolver\Checker
 * @TODO: Переделать на Zend\Http\Cookie
 */
class CheckCookieResolver implements CheckInterface
{
    /**
     * @param PollInterface $poll
     * @return bool
     */
    public function check(PollInterface $poll)
    {
        /** @var string $relation */
        $relation = '';

        if ($poll instanceof RelationInterface) {
            $relation = $poll->getCode();
        }

        /** @var string $key */
        $key = md5($poll->getId() . md5($relation));

        return array_key_exists($key, $_COOKIE);
    }
}
