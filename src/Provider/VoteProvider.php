<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Doctrine\Provider;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use MSBios\Doctrine\ObjectManagerAwareTrait;
use MSBios\Resource\Doctrine\EntityInterface;
use MSBios\Voting\Resource\Doctrine\Entity\Option;
use MSBios\Voting\Resource\Doctrine\Entity\Vote;

/**
 * Class VoteProvider
 * @package MSBios\Voting\Doctrine\Provider
 */
class VoteProvider implements
    VoteProviderInterface,
    ObjectManagerAwareInterface
{
    use ObjectManagerAwareTrait;

    /**
     * @param $id
     */
    public function write($id)
    {
        /** @var ObjectManager $dem */
        $dem = $this->getObjectManager();

        /** @var EntityInterface $option */
        $option = $dem->find(Option::class, $id);

        /** @var ObjectRepository $repository */
        $repository = $dem->getRepository(Vote::class);

        /** @var EntityInterface $vote */
        $vote = $repository->findOneBy(['option' => $option]);

        if (! $vote) {

            /** @var EntityInterface $vote */
            $vote = new Vote;
            $vote->setPoll($option->getPoll())
                ->setOption($option)
                ->setCreatedAt(new \DateTime('now'))
                ->setModifiedAt(new \DateTime('now'));

            $dem->persist($vote);
            $dem->flush();
        }

        $vote->setTotal(1 + $vote->getTotal())
            ->setModifiedAt(new \DateTime('now'));

        $dem->merge($vote);
        $dem->flush();
    }
}
