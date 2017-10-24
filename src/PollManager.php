<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Doctrine;

use Doctrine\Common\Persistence\ObjectRepository;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use MSBios\Doctrine\ObjectManagerAwareTrait;
use MSBios\Form\FormElementAwareTrait;
use MSBios\Resource\Doctrine\EntityInterface;
use MSBios\Stdlib\ObjectInterface;
use MSBios\Voting\Doctrine\Exception\InvalidArgumentException;
use MSBios\Voting\PollManagerInterface;
use MSBios\Voting\Resource\Doctrine\Entity\Option;
use MSBios\Voting\Resource\Doctrine\Entity\Poll;
use MSBios\Voting\Resource\Doctrine\Entity\Vote;
use Zend\Form\FormInterface;

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

    /** @var array|EntityInterface */
    protected $polls = [];

    /** @var EntityInterface */
    protected $current;

    /** @var array|FormInterface */
    protected $forms = [];

    /**
     * @param $id
     * @param null $relation
     * @return mixed|EntityInterface|Poll\Relation
     * @throws \Exception
     */
    public function find($id, $relation = null)
    {
        /** @var string $hash */
        $hash = md5((! is_null($relation)) ? $relation : $id);

        if (isset($this->polls[$hash])) {
            return $this->polls[$hash];
        }

        /** @var EntityInterface $poll */
        $poll = $this->getObjectManager()->find(Poll::class, $id);

        if (! $poll) {
            throw new \Exception('Poll can not be found');
        }

        $this->current = $poll;

        if (is_null($relation)) {
            $this->polls[$hash] = $this->current;
            return $poll;
        }

        /** @var ObjectRepository $repository */
        $repository = $this->getObjectManager()
            ->getRepository(Poll\Relation::class);

        /** @var EntityInterface $entity */
        $entity = $repository->findOneBy([
            'poll' => $poll->getId(),
            'code' => $relation
        ]);

        if (! $entity) {
            /** @var EntityInterface $entity */
            $entity = new Poll\Relation;
            $entity->setPoll($poll)
                ->setCode($relation)
                ->setCreatedAt(new \DateTime('now'))
                ->setModifiedAt(new \DateTime('now'));

            $this->getObjectManager()->persist($entity);
            $this->getObjectManager()->flush();
        }

        $this->current = $entity;
        $this->polls[$hash] = $this->current;
        return $entity;
    }

    /**
     * @return FormInterface
     */
    public function form()
    {
        /** @var FormInterface $formElement */
        $formElement = $this->getFormElement();
        $formElement->getOptionElement()->setOption('find_method', [
            'name' => 'findBy',
            'params' => [
                'criteria' => [
                    'poll' => $this->current->getId()
                ],
                // I need this to be the content id
                'orderBy' => ['priority' => 'desc'],
            ],
        ]);
        return $formElement;
    }

    /**
     * @param Option $left
     * @param Option $right
     * @return int
     */
    protected function uSortOptions(Option $left, Option $right)
    {
        if ($left->getPriority() == $right->getPriority()) {
            return 0;
        }
        return ($left->getPriority() < $right->getPriority()) ? -1 : 1;
    }

    /**
     * @param ObjectInterface $option
     */
    public function vote(ObjectInterface $option)
    {
        if (! $option instanceof Option) {
            throw new InvalidArgumentException('Passed argument must be implement ' . Option::class);
        }

        /** @var Vote|ObjectInterface $vote */
        $vote = $option->getVote();

        if (! $vote) {
            /** @var Vote|ObjectInterface $vote */
            $vote = new Vote;
            $vote->setPoll($option->getPoll())
                ->setOption($option)
                ->setCreatedAt(new \DateTime('now'))
                ->setModifiedAt(new \DateTime('now'));

            $this->objectManager->persist($vote);
            $this->objectManager->flush();
        }

        $vote->setTotal(1 + $vote->getTotal());
        $vote->setModifiedAt(new \DateTime('now'));
        $this->objectManager->merge($vote);
        $this->objectManager->flush();
    }
}
