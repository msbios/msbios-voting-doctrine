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
     * @param VoteManager $voteManager
     */
    public function __construct(ObjectManager $objectManager, VoteManager $voteManager)
    {
        $this->setObjectManager($objectManager);
        $this->setVoteManager($voteManager);
    }

    /**
     * @param $idOrCode
     * @param null $relation
     * @return PollInterface
     * @throws \Exception
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

    /**
     * @param PollInterface $poll
     */
    public function option(PollInterface $poll)
    {
        // ...
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
    public function votes(PollInterface $poll)
    {
        return $this
            ->getVoteManager()
            ->votes($poll);
    }
}
