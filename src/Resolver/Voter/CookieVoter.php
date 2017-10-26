<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Doctrine\Resolver\Voter;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use MSBios\Doctrine\ObjectManagerAwareTrait;
use MSBios\Resource\Doctrine\EntityInterface;
use MSBios\Voting\Doctrine\Resolver\VoteInterface;
use MSBios\Voting\Resource\Doctrine\Entity;

/**
 * Class CookieVoter
 * @package MSBios\Voting\Doctrine\Resolver\Voter
 */
class CookieVoter implements VoteInterface, ObjectManagerAwareInterface
{
    use ObjectManagerAwareTrait;

    /**
     * @param $id
     * @param null $relation
     */
    public function write($id, $relation = null)
    {
        /** @var ObjectManager $dem */
        $dem = $this->getObjectManager();
        $poll = $dem->getRepository(Entity\Poll\Relation::class)->findOneBy([
            'code' => $relation
        ]);

        if (! $poll) {
            /** @var EntityInterface $poll */
            $option = $dem->find(Entity\Option::class, $id);
            $poll = $option->getPoll();
        }

        /** @var string $key */
        $key = md5($poll->getId() . md5($relation));

        // r($key); die(); // 54f79c7761bedeec293df09c0599f882

        setcookie($key, 1, time() + 60 * 60 * 24 * 365);
    }
}
