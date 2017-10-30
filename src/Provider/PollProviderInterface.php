<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine\Provider;

/**
 * Interface PollProviderInterface
 * @package MSBios\Voting\Doctrine\Provider
 */
interface PollProviderInterface
{
    /**
     * @param $idOrCode
     * @return mixed
     */
    public function find($idOrCode);
}
