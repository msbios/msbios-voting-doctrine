<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Doctrine\Provider\Vote;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use MSBios\Resource\Doctrine\EntityInterface;
use MSBios\Voting\Doctrine\Provider\VoteProvider;
use MSBios\Voting\Resource\Doctrine\Entity;

/**
 * Class RelationProvider
 * @package MSBios\Voting\Doctrine\Provider\Vote
 */
class RelationProvider extends VoteProvider implements RelationProviderInterface
{
    /**
     * @param $id
     * @param null $relation
     * @return mixed|void
     */
    public function write($id, $relation = null)
    {
        if (empty($relation)) {
            return parent::write($id);
        }

        /** @var ObjectManager $dem */
        $dem = $this->getObjectManager();

        /** @var EntityInterface $poll */
        $poll = $dem->getRepository(Entity\Poll\Relation::class)->findOneBy([
            'code' => $relation
        ]);

        /** @var EntityInterface $option */
        $option = $dem->find(Entity\Option::class, $id);

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

        $vote->setTotal(1 + $vote->getTotal())
            ->setModifiedAt(new \DateTime('now'));

        $dem->merge($vote);
        $dem->flush();
    }
}
