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
     * @param $idOrCode
     * @return null|object
     */
    public function find($idOrCode)
    {
        return $this->getObjectManager()
            ->getRepository(Poll::class)
            ->find($idOrCode);
    }
}
