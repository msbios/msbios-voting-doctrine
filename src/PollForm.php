<?php
/**
 * Created by PhpStorm.
 * User: judzhin
 * Date: 10/24/17
 * Time: 3:46 PM
 */

namespace MSBios\Voting\Doctrine;

use DoctrineModule\Form\Element\ObjectRadio;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use MSBios\Doctrine\ObjectManagerAwareTrait;
use MSBios\Voting\PollForm as DefaultPollForm;
use MSBios\Voting\Resource\Doctrine\Entity\Option;

/**
 * Class PollForm
 * @package MSBios\Voting\Doctrine
 */
class PollForm extends DefaultPollForm implements ObjectManagerAwareInterface
{

    use ObjectManagerAwareTrait;

    public function init()
    {
        parent::init();

        /** @var string $name */
        $name = $this->config->get('default_option_key');
        $this->remove($name);

        $this->add([
            'type' => ObjectRadio::class,
            'name' => $name,
            'options' => [
                'object_manager' => $this->getObjectManager(),
                'target_class' => Option::class,
                'property' => 'name',
                'is_method' => true,
                // 'find_method' => []
            ]
        ]);
    }
}
