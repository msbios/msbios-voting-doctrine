<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine;

use MSBios\Stdlib\AbstractObject;

/**
 * Class VoteContext
 * @package MSBios\Voting\Doctrine
 */
class VoteContext extends AbstractObject
{
    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->getData('name');
    }

    /**
     * @return mixed
     */
    public function getPercent()
    {
        return $this->getData('percent');
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->getData('total');
    }

    /**
     * @param array $variant
     * @return VoteContext
     */
    public static function factory(array $variant)
    {
        return new self($variant);
    }
}
