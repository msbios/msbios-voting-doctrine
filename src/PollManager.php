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

    /** @var Provider\Vote\RelationProviderInterface */
    protected $voteProvider;

    /** @var CheckManagerInterface */
    protected $checkManager;

    /** @var VoteManagerInterface */
    protected $voteManager;

    /** @var EntityInterface */
    protected $current;

    /** @var int */
    protected $identifier;

    /** @var string */
    protected $relation;

    /**
     * PollManager constructor.
     * @param Provider\PollProviderInterface $pollProvider
     * @param Provider\VoteProviderInterface $voteProvider
     * @param CheckManagerInterface $checkManager
     */
    public function __construct(
        Provider\PollProviderInterface $pollProvider,
        // Provider\VoteProviderInterface $voteProvider,
        VoteManagerInterface $voteManager,
        CheckManagerInterface $checkManager
    ) {
        $this->pollProvider = $pollProvider;
        // $this->voteProvider = $voteProvider;
        $this->voteManager = $voteManager;
        $this->checkManager = $checkManager;
    }

    /**
     * @param $id
     * @param null $relation
     * @return mixed|EntityInterface
     */
    public function find($id, $relation = null)
    {
        /** @var EntityInterface $entity */
        return $this->pollProvider->find($id, $relation);
    }

    /**
     * @param $id
     * @param null $relation
     * @return mixed
     */
    public function vote($id, $relation = null)
    {
        return $this->voteManager->write($id, $relation);
        // return $this->voteProvider->write($id, $relation);
    }

    /**
     * @param ObjectInterface $poll
     * @return mixed
     */
    public function isVoted(ObjectInterface $poll)
    {
        return $this->checkManager->check($poll);
    }
}
