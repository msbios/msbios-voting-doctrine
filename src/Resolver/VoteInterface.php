<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine\Resolver;

use MSBios\Voting\Resource\Record\OptionInterface;
use MSBios\Voting\Resource\Record\PollInterface;

/**
 * Interface VoteInterface
 * @package MSBios\Voting\Doctrine\Resolver
 */
interface VoteInterface
{
    /**
     * @param PollInterface $poll
     * @param OptionInterface $option
     * @return mixed
     */
    public function vote(PollInterface $poll, OptionInterface $option);

    /**
     * @param PollInterface $poll
     * @param OptionInterface $option
     * @return mixed
     */
    public function undo(PollInterface $poll, OptionInterface $option);
}
