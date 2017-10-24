<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Voting\Doctrine\Controller\Plugin;

use MSBios\Voting\Controller\Plugin\PollPlugin as DefaultPollPlugin;

/**
 * Class PollPlugin
 * @package MSBios\Voting\Doctrine\Controller\Plugin
 */
class PollPlugin extends DefaultPollPlugin
{
    /**
     * @return bool
     */
    public function vote()
    {
        if ($this->isValid()) {



            $this->pollManager->vote();
            return true;
        }

        return false;
    }

}
