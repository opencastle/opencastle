<?php
/**
 * Created by PhpStorm.
 * User: zack
 * Date: 01.12.15
 * Time: 19:31
 */

namespace OpenCastle\CoreBundle\Tests\GameEvent;

use OpenCastle\CoreBundle\GameEvent\GameEventInterface;
use Symfony\Component\EventDispatcher\Event;

class GameEventInterfaceTest extends Event implements GameEventInterface
{

    /**
     * @var string
     */
    private $type;

    /**
     * @var integer
     */
    private $sender;

    public function __construct($type = null)
    {
        $this->type = $type;
    }

    /**
     * @inheritDoc
     */
    public function setSender($sender)
    {
        $this->sender = $sender;
    }

    /**
     * @inheritDoc
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @inheritDoc
     */
    public function setReceiver($receiver)
    {
        // TODO: Implement setReceiver() method.
    }

    /**
     * @inheritDoc
     */
    public function getReceiver()
    {
        // TODO: Implement getReceiver() method.
    }

    /**
     * @inheritDoc
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @inheritDoc
     */
    public function getMessage()
    {
        // TODO: Implement getMessage() method.
    }

    /**
     * @inheritDoc
     */
    public function setDate(\DateTime $date)
    {
        // TODO: Implement setDate() method.
    }
}