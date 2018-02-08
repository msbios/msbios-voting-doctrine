<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine\Provider;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use MSBios\Doctrine\ObjectManagerAwareTrait;
use MSBios\Voting\Resource\Doctrine\Entity\Poll;
use MSBios\Voting\Resource\Doctrine\Entity\PollInterface;

/**
 * Class PollProvider
 * @package MSBios\Voting\Doctrine\Provider
 */
class PollProvider implements
    PollProviderInterface,
    ObjectManagerAwareInterface
{
    use ObjectManagerAwareTrait;

    /**
     * @param $idOrCode
     * @param null $relation
     * @return Poll\Relation|PollInterface
     */
    public function find($idOrCode, $relation = null)
    {
        /** @var ObjectManager $dem */
        $dem = $this->getObjectManager();

        /** @var PollInterface $poll */
        $poll = $dem->getRepository(Poll::class)
            ->find($idOrCode);

        if (is_null($relation) || empty($relation)) {
            return $poll;
        }

        /** @var ObjectRepository $repository */
        $repository = $dem->getRepository(Poll\Relation::class);

        /** @var PollInterface $entity */
        $entity = $repository->findOneBy([
            'poll' => $poll,
            'code' => $relation
        ]);

        if (! $entity && $poll) {

            /** @var PollInterface $entity */
            $entity = new Poll\Relation;
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
