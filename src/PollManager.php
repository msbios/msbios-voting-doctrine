<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use MSBios\Resource\Doctrine\EntityInterface;
use MSBios\Stdlib\ObjectInterface;
use MSBios\Voting\Doctrine\Exception\InvalidArgumentException;
use MSBios\Voting\PollManagerInterface;
use MSBios\Voting\Resource\Doctrine\Entity\Option;
use MSBios\Voting\Resource\Doctrine\Entity\Poll;
use MSBios\Voting\Resource\Doctrine\Entity\Vote;

/**
 * Class PollManager
 * @package MSBios\Voting\Doctrine
 * @link https://www.codexworld.com/online-poll-voting-system-php-mysql/
 */
class PollManager implements PollManagerInterface
{
    /** @var  ObjectManager */
    protected $objectManager;

    /**
     * PollManager constructor.
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @param $id
     * @param null $relation
     * @return EntityInterface|Poll\Relation
     */
    public function find($id, $relation = null)
    {
        /** @var EntityInterface $poll */
        $poll = $this->objectManager->find(Poll::class, $id);

        if (! $poll) {
            throw new \Exception('Poll can not find');
        }

        if (is_null($relation)) {
            return $poll;
        }

        /** @var EntityInterface $entity */
        $entity = $this->objectManager->getRepository(Poll\Relation::class)->findOneBy([
            'poll' => $poll->getId(),
            'code' => $relation
        ]);

        if (! $entity) {
            /** @var EntityInterface $entity */
            $entity = new Poll\Relation;
            $entity->setPoll($poll)
                ->setCode($relation)
                ->setCreatedAt(new \DateTime('now'))
                ->setModifiedAt(new \DateTime('now'));

            $this->objectManager->persist($entity);
            $this->objectManager->flush();
        }

        $entity->setOptions($poll->getOptions());

        return $entity;
    }

    /**
     * @param ObjectInterface $option
     */
    public function vote(ObjectInterface $option)
    {
        if (! $option instanceof Option) {
            throw new InvalidArgumentException('Passed argument must be implement ' . Option::class);
        }

        /** @var Vote|ObjectInterface $vote */
        $vote = $option->getVote();

        if (! $vote) {
            /** @var Vote|ObjectInterface $vote */
            $vote = new Vote;
            $vote->setPoll($option->getPoll())
                ->setOption($option)
                ->setCreatedAt(new \DateTime('now'))
                ->setModifiedAt(new \DateTime('now'));

            $this->objectManager->persist($vote);
            $this->objectManager->flush();
        }

        $vote->setTotal(1 + $vote->getTotal());
        $vote->setModifiedAt(new \DateTime('now'));
        $this->objectManager->merge($vote);
        $this->objectManager->flush();
    }
}
