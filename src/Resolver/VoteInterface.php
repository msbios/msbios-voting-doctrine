<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine\Resolver;

use MSBios\Stdlib\ObjectInterface;

/**
 * Interface VoteInterface
 * @package MSBios\Voting\Doctrine\Resolver
 */
interface VoteInterface
{
    /**
     * @param $id
     * @param null $relation
     * @return mixed
     */
    public function write($id, $relation = null);
}
