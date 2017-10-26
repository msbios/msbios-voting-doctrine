<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine\Resolver;

/**
 *
 * Interface ResolverInterface
 * @package MSBios\Voting\Doctrine\Resolver
 */
interface ResolverInterface
{
    /**
     * @param $value
     * @return mixed
     */
    public function resolve($value);
}
