<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine\Resolver\Voter;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use MSBios\Doctrine\ObjectManagerAwareTrait;
use MSBios\Resource\Doctrine\EntityInterface;
use MSBios\Voting\Doctrine\Resolver\VoteInterface;
use MSBios\Voting\Resource\Doctrine\Entity;

/**
 * Class RepositoryVoter
 * @package MSBios\Voting\Doctrine\Resolver\Voter
 */
class RepositoryVoter implements VoteInterface, ObjectManagerAwareInterface
{
    use ObjectManagerAwareTrait;

    /**
     * @param $id
     * @param null $relation
     * @return mixed
     */
    public function write($id, $relation = null)
    {

        /** @var ObjectManager $dem */
        $dem = $this->getObjectManager();

        /** @var EntityInterface $option */
        $option = $dem->find(Entity\Option::class, $id);

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

        $vote->setTotal(1 + $vote->getTotal())
            ->setModifiedAt(new \DateTime('now'));

        $dem->merge($vote);
        $dem->flush();
    }
}
