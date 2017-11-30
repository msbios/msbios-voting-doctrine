<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Doctrine;

use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use MSBios\Doctrine\ObjectManagerAwareTrait;
use MSBios\Form\FormElementAwareTrait;
use MSBios\Resource\Doctrine\EntityInterface;
use MSBios\Stdlib\ObjectInterface;
use MSBios\Voting\Doctrine\Provider;
use MSBios\Voting\Doctrine\Resolver\CheckManagerInterface;
use MSBios\Voting\Doctrine\Resolver\VoteManagerInterface;
use MSBios\Voting\PollManagerInterface;
use MSBios\Voting\Resource\Doctrine\Entity\PollInterface;

/**
 * Class PollManager
 * @package MSBios\Voting\Doctrine
 * @link https://www.codexworld.com/online-poll-voting-system-php-mysql/
 */
class PollManager implements
    PollManagerInterface,
    ObjectManagerAwareInterface
{
    use ObjectManagerAwareTrait;
    use FormElementAwareTrait;

    /** @var Provider\PollProviderInterface */
    protected $pollProvider;

    /** @var CheckManagerInterface */
    protected $checkManager;

    /** @var VoteManagerInterface */
    protected $voteManager;

    /** @var PollInterface */
    protected $current;

    /**
     * PollManager constructor.
     * @param Provider\PollProviderInterface $pollProvider
     * @param VoteManagerInterface $voteManager
     * @param CheckManagerInterface $checkManager
     */
    public function __construct(
        Provider\PollProviderInterface $pollProvider,
        VoteManagerInterface $voteManager,
        CheckManagerInterface $checkManager
    ) {
        $this->pollProvider = $pollProvider;
        $this->voteManager = $voteManager;
        $this->checkManager = $checkManager;
    }

    /**
     * @param $idOrCode
     * @param null $relation
     * @return mixed|PollInterface
     */
    public function find($idOrCode, $relation = null)
    {
        $this->current = $this->pollProvider->find($idOrCode, $relation);
        return $this->current;
    }

    /**
     * @return PollInterface
     */
    public function current()
    {
        return $this->current;
    }

    /**
     * @param $id
     * @param null $relation
     * @return mixed
     */
    public function vote($id, $relation = null)
    {
        /** @var boolean $result */
        $result = $this->voteManager->write($id, $relation);
        $this->current = $this->find($id, $relation);
        return $result;
    }

    /**
     * @param ObjectInterface $poll
     * @return mixed
     */
    public function isVoted(ObjectInterface $poll)
    {
        return $this->checkManager->check($poll);
    }

    /**
     * @param ObjectInterface $poll
     * @return mixed
     */
    public function votes(ObjectInterface $poll)
    {
        /** @var string $className */
        $className = get_class($poll);
        return $this->getObjectManager()
            ->getRepository($className)
            ->findVotesBy($poll);
    }
}
