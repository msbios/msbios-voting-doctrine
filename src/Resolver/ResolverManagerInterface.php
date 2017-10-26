<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine\Resolver;

/**
 * Interface ResolverManagerInterface
 * @package MSBios\Voting\Doctrine\Resolver
 */
interface ResolverManagerInterface extends ResolverInterface
{
    /**
     * @param ResolverInterface $resolver
     * @param int $priority
     * @return mixed
     */
    public function attach(ResolverInterface $resolver, $priority = 1);
}
