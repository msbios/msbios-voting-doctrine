<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Doctrine\Resolver;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Persistence\ProvidesObjectManager;
use MSBios\Resource\Doctrine\EntityInterface;
use MSBios\Voting\Resource\Doctrine\Entity\Vote;
use MSBios\Voting\Resource\Doctrine\Entity\VoteRelation;
use MSBios\Voting\Resource\Record\OptionInterface;
use MSBios\Voting\Resource\Record\PollInterface;
use MSBios\Voting\Resource\Record\RelationInterface;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;

/**
 * Class VoteRepositoryResolver
 * @package MSBios\Voting\Doctrine\Resolver
 */
class VoteRepositoryResolver implements ObjectManagerAwareInterface, EventManagerAwareInterface, VoteInterface
{
    use ProvidesObjectManager;
    use EventManagerAwareTrait;

    /** @const EVENT_FIND_VOTE */
    const EVENT_FIND_VOTE = 'EVENT_FIND_VOTE';

    /** @const EVENT_VOTE_MERGE */
    const EVENT_VOTE_MERGE = 'EVENT_VOTE_MERGE';

    /** @const EVENT_UNDO_MERGE */
    const EVENT_UNDO_MERGE = 'EVENT_UNDO_MERGE';

    /**
     * VoteRepositoryResolver constructor.
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        $this->setObjectManager($objectManager);
    }

    /**
     * @param PollInterface $poll
     * @param OptionInterface $option
     * @return EntityInterface
     * @throws \Exception
     */
    public function find(PollInterface $poll, OptionInterface $option)
    {
        /** @var ObjectManager $dem */
        $dem = $this->getObjectManager();

        if ($poll instanceof RelationInterface) {

            /** @var ObjectRepository $repository */
            $repository = $dem->getRepository(VoteRelation::class);

            /** @var EntityInterface $vote */
            $vote = $repository->findOneBy([
                'poll' => $poll,
                'option' => $option
            ]);

            if (! $vote) {
                /** @var EntityInterface $vote */
                $vote = new VoteRelation;
                $vote->setPoll($poll)
                    ->setOption($option)
                    ->setCreatedAt(new \DateTime)
                    ->setModifiedAt(new \DateTime);

                $dem->persist($vote);
                $dem->flush();
            }

            return $vote;
        }

        /** @var ObjectRepository $repository */
        $repository = $dem->getRepository(Vote::class);

        /** @var EntityInterface $vote */
        $vote = $repository->findOneBy(['option' => $option]);

        if (! $vote) {

            /** @var EntityInterface $vote */
            $vote = new Vote;
            $vote->setPoll($option->getPoll())
                ->setOption($option)
                ->setCreatedAt(new \DateTime)
                ->setModifiedAt(new \DateTime);

            $dem->persist($vote);
            $dem->flush();
        }

        $this->getEventManager()
            ->trigger(self::EVENT_FIND_VOTE, $this, ['vote' => $vote]);

        return $vote;
    }

    /**
     * @param \MSBios\Voting\Resource\Record\VoteInterface $vote
     * @return $this
     */
    private function merge(\MSBios\Voting\Resource\Record\VoteInterface $vote)
    {
        /** @var ObjectManager $dem */
        $dem = $this->getObjectManager();
        $dem->merge($vote);
        $dem->flush();

        return $this;
    }

    /**
     * @param PollInterface $poll
     * @param OptionInterface $option
     * @return mixed
     * @throws \Exception
     */
    public function vote(PollInterface $poll, OptionInterface $option)
    {
        /** @var array $argv */
        $argv = ['poll' => $poll, 'option' => $option];
        $argv['vote'] = $this->find($argv['poll'], $argv['option']);
        $argv['vote']->setTotal(1 + $argv['vote']->getTotal())
            ->setModifiedAt(new \DateTime);

        $this->merge($argv['vote']);
        $this->getEventManager()
            ->trigger(self::EVENT_VOTE_MERGE, $this, $argv);

        return $argv['vote'];
    }

    /**
     * @param PollInterface $poll
     * @param OptionInterface $option
     * @return mixed|EntityInterface
     * @throws \Exception
     */
    public function undo(PollInterface $poll, OptionInterface $option)
    {
        /** @var array $argv */
        $argv = ['poll' => $poll, 'option' => $option];
        $argv['vote'] = $this->find($argv['poll'], $argv['option']);
        $argv['vote']->setTotal($argv['vote']->getTotal() ? $argv['vote']->getTotal() - 1 : 0)
            ->setModifiedAt(new \DateTime);

        $this->merge($argv['vote']);
        $this->getEventManager()
            ->trigger(self::EVENT_UNDO_MERGE, $this, $argv);

        return $argv['vote'];
    }
}
