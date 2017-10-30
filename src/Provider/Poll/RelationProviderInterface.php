<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine\Provider\Poll;

use MSBios\Voting\Doctrine\Provider\PollProviderInterface;

/**
 * Interface RelationProviderInterface
 * @package MSBios\Voting\Doctrine\Provider\Poll
 */
interface RelationProviderInterface extends PollProviderInterface
{
    /**
     * @param $idOrCode
     * @param null $relation
     * @return mixed
     */
    public function find($idOrCode, $relation = null);
}
