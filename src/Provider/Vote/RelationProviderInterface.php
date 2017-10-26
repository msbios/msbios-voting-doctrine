<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine\Provider\Vote;

use MSBios\Voting\Doctrine\Provider\VoteProviderInterface;

/**
 * Interface RelationProviderInterface
 * @package MSBios\Voting\Doctrine\Provider\Vote
 */
interface RelationProviderInterface extends VoteProviderInterface
{
    /**
     * @param $id
     * @param null $relation
     * @return mixed
     */
    public function write($id, $relation = null);
}
