<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine\Provider;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Persistence\ProvidesObjectManager;
use MSBios\Voting\Resource\Doctrine\Entity\Poll;
use MSBios\Voting\Resource\Doctrine\Entity\PollRelation;
use MSBios\Voting\Resource\Record\PollInterface;

/**
 * Class PollProvider
 * @package MSBios\Voting\Doctrine\Provider
 */
class PollProvider implements ObjectManagerAwareInterface, PollProviderInterface
{
    use ProvidesObjectManager;

    /**
     * PollProvider constructor.
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        $this->setObjectManager($objectManager);
    }

    /**
     * @param $idOrCode
     * @param null $relation
     * @return mixed|PollInterface
     */
    public function find($idOrCode, $relation = null)
    {
        /** @var ObjectManager $dem */
        $dem = $this->getObjectManager();

        /** @var PollInterface $poll */
        $poll = $dem->getRepository(Poll::class)
            ->find($idOrCode);

        if ($poll && ! is_null($relation)) {

            /** @var ObjectRepository $repository */
            $repository = $dem->getRepository(PollRelation::class);

            /** @var PollInterface $pollRelation */
            $pollRelation = $repository->findOneBy([
                'poll' => $poll,
                'code' => $relation
            ]);

            if (! $pollRelation) {

                /** @var PollInterface $entity */
                $pollRelation = new PollRelation;
                $pollRelation->setPoll($poll)
                    ->setCode($relation)
                    ->setCreatedAt(new \DateTime)
                    ->setModifiedAt(new \DateTime);
                $dem->persist($pollRelation);
                $dem->flush();
            }

            return $pollRelation;
        }

        return $poll;
    }
}
