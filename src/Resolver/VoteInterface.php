<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine\Resolver;

use MSBios\Voting\Resource\Record\OptionInterface;

/**
 * Interface VoteInterface
 * @package MSBios\Voting\Doctrine\Resolver
 */
interface VoteInterface
{
    /**
     * @param OptionInterface $option
     * @param null $relation
     * @return mixed
     */
    public function vote(OptionInterface $option, $relation = null);

    /**
     * @param OptionInterface $option
     * @param null $relation
     * @return mixed
     */
    public function undo(OptionInterface $option, $relation = null);
}
