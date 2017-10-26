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
     * @param $optionId
     */
    public function write($id, $optionId)
    {
        ///** @var ObjectManager $dem */
        //$dem = $this->getObjectManager();
        //
        ///** @var EntityInterface $option */
        //$option = $dem->find(Option::class, $this->identifier);
        //
        ///** @var ObjectRepository $repository */
        //$repository = $dem->getRepository(Vote::class);
        //
        ///** @var EntityInterface $entity */
        //$entity = $repository->findOneBy(['option' => $option]);
        //
        //if (!$entity) {
        //
        //    /** @var EntityInterface $entity */
        //    $entity = new Vote;
        //    $entity->setPoll($option->getPoll())
        //        ->setOption($option)
        //        ->setCreatedAt(new \DateTime('now'))
        //        ->setModifiedAt(new \DateTime('now'));
        //
        //    $dem->persist($entity);
        //
        //} else {
        //    $entity->setTotal(1 + $entity->getTotal())
        //        ->setModifiedAt(new \DateTime('now'));
        //    $dem->merge($entity);
        //}
        //
        //$dem->flush();
    }
}
