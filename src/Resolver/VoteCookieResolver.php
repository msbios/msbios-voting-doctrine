<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Doctrine\Resolver;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use MSBios\Doctrine\ObjectManagerAwareTrait;
use MSBios\Resource\Doctrine\EntityInterface;
use MSBios\Voting\Doctrine\Resolver\VoteInterface;
use MSBios\Voting\Resource\Doctrine\Entity;

/**
 * Class VoteCookieResolver
 * @package MSBios\Voting\Doctrine\Resolver\Voter
 */
class VoteCookieResolver implements VoteInterface, ObjectManagerAwareInterface
{
    use ObjectManagerAwareTrait;

    /**
     * @param Entity\OptionInterface $option
     * @param null $relation
     * @return string
     */
    protected function hash(Entity\OptionInterface $option, $relation = null)
    {
        return md5($option->getPoll()->getId() . md5($relation));
    }

    /**
     * @param Entity\OptionInterface $option
     * @param null $relation
     */
    public function vote(Entity\OptionInterface $option, $relation = null)
    {
        /** @var string $key */
        $key = $this->hash($option, $relation);
        setcookie($key, 1, time() + 60 * 60 * 24 * 365);
    }

    /**
     * @param Entity\OptionInterface $option
     * @param null $relation
     */
    public function undo(Entity\OptionInterface $option, $relation = null)
    {
        /** @var string $key */
        $key = $this->hash($option, $relation);
        if (isset($_COOKIE[$key])) {
            unset($_COOKIE[$key]);
            setcookie($key, null, -1);
        }
    }
}
