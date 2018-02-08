<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Doctrine;

use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use MSBios\Doctrine\ObjectManagerAwareTrait;
use MSBios\Voting\OptionManagerInterface;

/**
 * Class OptionManager
 * @package MSBios\Voting\Doctrine
 */
class OptionManager implements OptionManagerInterface, ObjectManagerAwareInterface
{
    use ObjectManagerAwareTrait;

    /**
     * @param $id
     * @param $relation
     */
    public function find($id, $relation)
    {
    }
}
