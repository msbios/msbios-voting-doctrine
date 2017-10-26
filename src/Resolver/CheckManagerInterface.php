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
interface CheckManagerInterface extends CheckInterface
{
    /**
     * @param CheckInterface $resolver
     * @param int $priority
     * @return mixed
     */
    public function attach(CheckInterface $resolver, $priority = 1);
}
