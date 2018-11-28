<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine\Provider;

use MSBios\Voting\Resource\Record\PollInterface;

/**
 * Interface VoteProviderInterface
 * @package MSBios\Voting\Doctrine\Provider
 */
interface VoteProviderInterface
{
    /**
     * @param PollInterface $poll
     * @return mixed
     */
    public function find(PollInterface $poll);
}
