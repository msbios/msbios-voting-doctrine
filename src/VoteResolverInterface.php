<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine;

use MSBios\Voting\Doctrine\Resolver\VoteInterface;

/**
 * Interface VoteResolverInterface
 * @package MSBios\Voting\Doctrine
 */
interface VoteResolverInterface extends VoteInterface
{
    /**
     * @param VoteInterface $resolver
     * @param int $priority
     * @return mixed
     */
    public function attach(VoteInterface $resolver, $priority = 1);
}
