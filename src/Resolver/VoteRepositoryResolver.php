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
use MSBios\Voting\Resource\Doctrine\Entity;
use MSBios\Voting\Resource\Record\OptionInterface;

/**
 * Class VoteRepositoryResolver
 * @package MSBios\Voting\Doctrine\Resolver
 */
class VoteRepositoryResolver implements VoteInterface, ObjectManagerAwareInterface
{
    use ObjectManagerAwareTrait;

    /**
     * @param OptionInterface $option
     * @param null $relation
     * @return EntityInterface|Entity\Vote
     */
    protected function findVote(OptionInterface $option, $relation = null)
    {
        /** @var ObjectManager $dem */
        $dem = $this->getObjectManager();

        if (empty($relation)) {

            /** @var ObjectRepository $repository */
            $repository = $dem->getRepository(Entity\Vote::class);

            /** @var EntityInterface $vote */
            $vote = $repository->findOneBy(['option' => $option]);

            if (! $vote) {

                /** @var EntityInterface $vote */
                $vote = new Entity\Vote;
                $vote->setPoll($option->getPoll())
                    ->setOption($option)
                    ->setCreatedAt(new \DateTime('now'))
                    ->setModifiedAt(new \DateTime('now'));

                $dem->persist($vote);
                $dem->flush();
            }
        } else {

            /** @var EntityInterface $poll */
            $poll = $dem->getRepository(Entity\Poll\Relation::class)->findOneBy([
                'code' => $relation
            ]);

            /** @var ObjectRepository $repository */
            $repository = $dem->getRepository(Entity\Vote\Relation::class);

            /** @var EntityInterface $vote */
            $vote = $repository->findOneBy([
                'poll' => $poll,
                'option' => $option
            ]);

            if (! $vote) {
                /** @var EntityInterface $vote */
                $vote = new Entity\Vote\Relation;
                $vote->setPoll($poll)
                    ->setOption($option)
                    ->setCreatedAt(new \DateTime('now'))
                    ->setModifiedAt(new \DateTime('now'));

                $dem->persist($vote);
                $dem->flush();
            }
        }

        return $vote;
    }

    /**
     * @param OptionInterface $option
     * @param null $relation
     */
    public function vote(OptionInterface $option, $relation = null)
    {
        /** @var EntityInterface $vote */
        $vote = $this->findVote($option, $relation);
        $vote->setTotal(1 + $vote->getTotal())
            ->setModifiedAt(new \DateTime('now'));

        /** @var ObjectManager $dem */
        $dem = $this->getObjectManager();

        $dem->merge($vote);
        $dem->flush();
    }

    /**
     * @param OptionInterface $option
     * @param null $relation
     */
    public function undo(OptionInterface $option, $relation = null)
    {
        /** @var EntityInterface $vote */
        $vote = $this->findVote($option, $relation);

        if ($vote->getTotal()) {
            $vote->setTotal($vote->getTotal() - 1)
                ->setModifiedAt(new \DateTime('now'));

            /** @var ObjectManager $dem */
            $dem = $this->getObjectManager();
            $dem->merge($vote);
            $dem->flush();
        }
    }
}
