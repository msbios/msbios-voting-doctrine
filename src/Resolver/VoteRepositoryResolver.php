<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Doctrine\Resolver;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use MSBios\Doctrine\ObjectManagerAwareTrait;
use MSBios\Resource\Doctrine\EntityInterface;
use MSBios\Voting\Resource\Doctrine\Entity\Vote;
use MSBios\Voting\Resource\Doctrine\Entity\VoteRelation;
use MSBios\Voting\Resource\Record\OptionInterface;
use MSBios\Voting\Resource\Record\PollInterface;
use MSBios\Voting\Resource\Record\RelationInterface;

/**
 * Class VoteRepositoryResolver
 * @package MSBios\Voting\Doctrine\Resolver
 */
class VoteRepositoryResolver implements ObjectManagerAwareInterface, VoteInterface
{
    use ObjectManagerAwareTrait;

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
    protected function find(PollInterface $poll, OptionInterface $option)
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

        return $vote;
    }

    /**
     * @param \MSBios\Voting\Resource\Record\VoteInterface $vote
     */
    private function merge(\MSBios\Voting\Resource\Record\VoteInterface $vote)
    {
        /** @var ObjectManager $dem */
        $dem = $this->getObjectManager();
        $dem->merge($vote);
        $dem->flush();
    }

    /**
     * @param PollInterface $poll
     * @param OptionInterface $option
     * @return mixed|void
     * @throws \Exception
     */
    public function vote(PollInterface $poll, OptionInterface $option)
    {
        /** @var EntityInterface $vote */
        $vote = $this->find($poll, $option);
        $vote->setTotal(1 + $vote->getTotal())
            ->setModifiedAt(new \DateTime);

        $this->merge($vote);
    }

    /**
     * @param PollInterface $poll
     * @param OptionInterface $option
     * @return mixed|void
     * @throws \Exception
     */
    public function undo(PollInterface $poll, OptionInterface $option)
    {
        /** @var EntityInterface $vote */
        $vote = $this->find($poll, $option);
        $vote->setTotal($vote->getTotal() ? $vote->getTotal() - 1 : 0)
            ->setModifiedAt(new \DateTime);

        $this->merge($vote);
    }
}
