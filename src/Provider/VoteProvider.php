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
use MSBios\Voting\Resource\Doctrine\Entity\Vote;
use MSBios\Voting\Resource\Record\PollInterface;
use MSBios\Voting\Resource\Record\RelationInterface;
use MSBios\Voting\Resource\Record\VoteRelation;

/**
 * Class VoteProvider
 * @package MSBios\Voting\Doctrine\Provider
 */
class VoteProvider implements ObjectManagerAwareInterface, VoteProviderInterface
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
     * @param PollInterface $poll
     * @return mixed|null|object
     */
    public function find(PollInterface $poll)
    {
        /** @var ObjectRepository $repository */
        $repository = $this->getObjectManager()
            ->getRepository($poll instanceof RelationInterface ? VoteRelation::class : Vote::class);

        return $repository->findOneBy([
            'poll' => $poll,
            'rowStatus' => true
        ]);
    }
}
