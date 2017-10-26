<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine\Resolver;

/**
 * Interface VoteManagerInterface
 * @package MSBios\Voting\Doctrine\Resolver
 */
interface VoteManagerInterface extends VoteInterface
{
    /**
     * @param VoteInterface $resolver
     * @param int $priority
     * @return mixed
     */
    public function attach(VoteInterface $resolver, $priority = 1);
}
