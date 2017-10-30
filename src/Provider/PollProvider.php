<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine\Provider;

use Doctrine\Common\Persistence\ObjectManager;
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
        /** @var ObjectManager $dem */
        $dem = $this->getObjectManager();

        if (is_numeric($idOrCode)) {
            return $dem->find(Poll::class, $idOrCode);
        }

        return $dem->getRepository(Poll::class)->findOneBy([
            'code' => $idOrCode
        ]);
    }
}
