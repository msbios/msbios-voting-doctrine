<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Doctrine\Provider\Vote;

use Doctrine\Common\Persistence\ObjectManager;
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
     * @param $optionId
     * @param null $relation
     * @return mixed|void
     */
    public function write($id, $optionId, $relation = null)
    {
        if (is_null($relation)) {
            return parent::write($id, $optionId);
        }

        /** @var ObjectManager $dem */
        $dem = $this->getObjectManager();

        /** @var EntityInterface $poll */
        $poll = $dem->getRepository(Entity\Poll\Relation::class)->findOneBy([
            'poll' => $id,
            'code' => $relation
        ]);

        /** @var EntityInterface $option */
        $option = $dem->find(Entity\Option::class, $optionId);

        /** @var EntityInterface $vote */
        $vote = $dem->getRepository(Entity\Vote\Relation::class)->findOneBy([
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
