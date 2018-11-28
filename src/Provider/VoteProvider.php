<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine\Provider;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Persistence\ProvidesObjectManager;
use MSBios\Voting\Resource\Record\PollInterface;

/**
 * Class VoteProvider
 * @package MSBios\Voting\Doctrine\Provider
 */
class VoteProvider implements ObjectManagerAwareInterface
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
     * @return PollInterface
     */
    public function find(PollInterface $poll)
    {
        return $poll;
    }
}
