<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine;

use MSBios\Voting\Doctrine\Resolver\CheckInterface;

/**
 * Interface CheckResolverInterface
 * @package MSBios\Voting\Doctrine
 */
interface CheckResolverInterface extends CheckInterface
{
    /**
     * @param CheckInterface $resolver
     * @param int $priority
     * @return $this
     */
    public function attach(CheckInterface $resolver, $priority = 1);
}
