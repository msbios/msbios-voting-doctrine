<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Persistence\ProvidesObjectManager;
use MSBios\Voting\Doctrine\Provider;
use MSBios\Voting\PollManagerInterface;
use MSBios\Voting\Resource\Doctrine\Entity\Option;
use MSBios\Voting\Resource\Doctrine\Entity\Poll;
use MSBios\Voting\Resource\Doctrine\Entity\PollRelation;
use MSBios\Voting\Resource\Record\OptionInterface;
use MSBios\Voting\Resource\Record\PollInterface;
use MSBios\Voting\Resource\Record\RelationInterface;
use MSBios\Voting\VoteManagerAwareInterface;
use MSBios\Voting\VoteManagerAwareTrait;

/**
 * Class PollManager
 * @package MSBios\Voting\Doctrine
 * @link https://www.codexworld.com/online-poll-voting-system-php-mysql/
 */
class PollManager implements PollManagerInterface, ObjectManagerAwareInterface, VoteManagerAwareInterface
{
    use ProvidesObjectManager;
    use VoteManagerAwareTrait;

    /** @var Provider\PollProviderInterface */
    protected $pollProvider;

    /**
     * PollManager constructor.
     * @param ObjectManager $objectManager
     * @param Provider\PollProvider $pollProvider
     * @param VoteManager $voteManager
     */
    public function __construct(
        ObjectManager $objectManager,
        Provider\PollProvider $pollProvider,
        VoteManager $voteManager
    ) {
        $this->setObjectManager($objectManager);
        $this->pollProvider = $pollProvider;
        $this->setVoteManager($voteManager);
    }

    /**
     * @param $idOrCode
     * @param null $relation
     * @return mixed|PollInterface
     */
    public function find($idOrCode, $relation = null)
    {
        return $this
            ->pollProvider
            ->find($idOrCode, $relation);
    }

    /**
     * @param PollInterface $poll
     * @param $id
     */
    public function vote(PollInterface $poll, $id)
    {
        /** @var OptionInterface $option */
        $option = $this
            ->getObjectManager()
            ->find(Option::class, $id);

        $this
            ->getVoteManager()
            ->vote($poll, $option);
    }

    /**
     * @param PollInterface $poll
     * @param $id
     */
    public function undo(PollInterface $poll, $id)
    {
        /** @var OptionInterface $option */
        $option = $this
            ->getObjectManager()
            ->find(Option::class, $id);

        $this
            ->getVoteManager()
            ->undo($poll, $option);
    }

    /**
     * @param PollInterface $poll
     * @return mixed
     */
    public function check(PollInterface $poll)
    {
        return $this
            ->getVoteManager()
            ->check($poll);
    }

    /**
     * @param PollInterface $poll
     * @return mixed
     */
    public function variants(PollInterface $poll)
    {
        /** @var ObjectManager $dem */
        $dem = $this->getObjectManager();

        if ($poll instanceof RelationInterface) {
            return $dem
                ->getRepository(PollRelation::class)
                ->findVotesBy($poll);
        }

        return $dem
            ->getRepository(Poll::class)
            ->findVotesBy($poll);
    }
}
