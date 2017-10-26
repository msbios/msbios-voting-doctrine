<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Voting\Doctrine\Provider;

/**
 * Interface VoteProviderInterface
 * @package MSBios\Voting\Doctrine\Provider
 */
interface VoteProviderInterface
{
    /**
     * @param $id
     * @param $optionId
     * @return mixed
     */
    public function write($id, $optionId);
}
