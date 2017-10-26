<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine\Provider;

use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use MSBios\Doctrine\ObjectManagerAwareTrait;
use MSBios\Voting\Resource\Doctrine\Entity\Poll;

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
     * @param $id
     * @return object
     */
    public function find($id)
    {
        return $this->getObjectManager()
            ->find(Poll::class, $id);
    }
}
