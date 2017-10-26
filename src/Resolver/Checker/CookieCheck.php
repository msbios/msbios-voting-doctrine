<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine\Resolver\Checker;

use MSBios\Stdlib\ObjectInterface;
use MSBios\Voting\Doctrine\Resolver\CheckInterface;

/**
 * Class CookieCheck
 * @package MSBios\Voting\Doctrine\Resolver\Checker
 */
class CookieCheck implements CheckInterface
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
