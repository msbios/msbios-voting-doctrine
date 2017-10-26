<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Doctrine\Provider\Poll;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use MSBios\Doctrine\ObjectManagerAwareTrait;
use MSBios\Resource\Doctrine\EntityInterface;
use MSBios\Voting\Doctrine\Provider\PollProvider;
use MSBios\Voting\Resource\Doctrine\Entity\Poll\Relation;

/**
 * Class RelationProvider
 * @package MSBios\Voting\Doctrine\Provider\Poll
 */
class RelationProvider extends PollProvider implements
    RelationProviderInterface,
    ObjectManagerAwareInterface
{
    use ObjectManagerAwareTrait;

    /**
     * @param $id
     * @param null $relation
     * @return EntityInterface|Relation
     */
    public function find($id, $relation = null)
    {
        /** @var EntityInterface $poll */
        $poll = parent::find($id);

        if (is_null($relation)) {
            return $poll;
        }

        /** @var ObjectManager $dem */
        $dem = $this->getObjectManager();

        /** @var ObjectRepository $repository */
        $repository = $dem->getRepository(Relation::class);

        /** @var EntityInterface $entity */
        $entity = $repository->findOneBy([
            'poll' => $poll,
            'code' => $relation
        ]);

        if (! $entity) {

            /** @var EntityInterface $entity */
            $entity = new Relation;
            $entity->setPoll($poll)
                ->setCode($relation)
                ->setCreatedAt(new \DateTime('now'))
                ->setModifiedAt(new \DateTime('now'));

            $dem->persist($entity);
            $dem->flush();
        }

        return $entity;
    }
}
