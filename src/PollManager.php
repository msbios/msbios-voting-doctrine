<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Doctrine;

use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use MSBios\Doctrine\ObjectManagerAwareTrait;
use MSBios\Form\FormElementAwareTrait;
use MSBios\Stdlib\ObjectInterface;
use MSBios\Voting\Doctrine\Provider;
use MSBios\Voting\Doctrine\Resolver\CheckManagerInterface;
use MSBios\Voting\Doctrine\Resolver\VoteManagerInterface;
use MSBios\Voting\PollManagerInterface;
use MSBios\Voting\Resource\Doctrine\Entity\Option;
use MSBios\Voting\Resource\Doctrine\Entity\OptionInterface;
use MSBios\Voting\Resource\Doctrine\Entity\PollInterface;
use MSBios\Voting\VoteManagerAwareInterface;
use MSBios\Voting\VoteManagerAwareTrait;

/**
 * Class PollManager
 * @package MSBios\Voting\Doctrine
 * @link https://www.codexworld.com/online-poll-voting-system-php-mysql/
 */
class PollManager implements
    PollManagerInterface,
    ObjectManagerAwareInterface,
    VoteManagerAwareInterface
{
    use ObjectManagerAwareTrait;
    use FormElementAwareTrait;
    use VoteManagerAwareTrait;

    /** @var Provider\PollProviderInterface */
    protected $pollProvider;

    /**
     * PollManager constructor.
     * @param Provider\PollProviderInterface $pollProvider
     */
    public function __construct(
        Provider\PollProviderInterface $pollProvider
    ) {
        $this->pollProvider = $pollProvider;
    }

    /**
     * @param $idOrCode
     * @param null $relation
     * @return mixed
     */
    public function find($idOrCode, $relation = null)
    {
        return $this->pollProvider->find($idOrCode, $relation);
    }

    /**
     * @param $id
     * @param null $relation
     */
    public function vote($id, $relation = null)
    {
        /** @var OptionInterface $option */
        $option = $this->getObjectManager()->find(Option::class, $id);
        $this->getVoteManager()->vote($option, $relation);
    }

    /**
     * @param $id
     * @param null $relation
     * @return mixed
     */
    public function undo($id, $relation = null)
    {
        /** @var OptionInterface $option */
        $option = $this->getObjectManager()->find(Option::class, $id);
        $this->getVoteManager()->undo($option, $relation);
    }

    /**
     * @param PollInterface $poll
     * @return mixed
     */
    public function isVoted(PollInterface $poll)
    {
        return $this->getVoteManager()->check($poll);
    }

    /**
     * @param PollInterface $poll
     * @return mixed
     */
    public function votes(PollInterface $poll)
    {
        /** @var string $className */
        $className = get_class($poll);
        return $this->getObjectManager()
            ->getRepository($className)
            ->findVotesBy($poll);
    }
}
