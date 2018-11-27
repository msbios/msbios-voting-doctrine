<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Persistence\ProvidesObjectManager;
use MSBios\Voting\OptionManagerInterface;
use MSBios\Voting\Resource\Record\PollInterface;

/**
 * Class OptionManager
 * @package MSBios\Voting\Doctrine
 */
class OptionManager implements ObjectManagerAwareInterface, OptionManagerInterface
{
    use ProvidesObjectManager;

    /**
     * OptionManager constructor.
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        $this->setObjectManager($objectManager);
    }

    /**
     * @param PollInterface $poll
     */
    public function find(PollInterface $poll)
    {
        // ...
    }
}
