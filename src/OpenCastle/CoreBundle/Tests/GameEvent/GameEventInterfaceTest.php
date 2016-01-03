<?php
/**
 * Created by PhpStorm.
 * User: zack
 * Date: 01.12.15
 * Time: 19:31.
 */
namespace OpenCastle\CoreBundle\Tests\GameEvent;

use OpenCastle\CoreBundle\GameEvent\GameEventInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class GameEventInterfaceTest
 * @package OpenCastle\CoreBundle\Tests\GameEvent
 */
class GameEventInterfaceTest extends Event implements GameEventInterface
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var int
     */
    private $sender;

    /**
     * GameEventInterfaceTest constructor.
     * @param null $type
     */
    public function __construct($type = null)
    {
        $this->type = $type;
    }

    /**
     * {@inheritdoc}
     */
    public function setSender($sender)
    {
        $this->sender = $sender;
    }

    /**
     * {@inheritdoc}
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * {@inheritdoc}
     */
    public function setReceiver($receiver)
    {
        // TODO: Implement setReceiver() method.
    }

    /**
     * {@inheritdoc}
     */
    public function getReceiver()
    {
        // TODO: Implement getReceiver() method.
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function getMessage()
    {
        // TODO: Implement getMessage() method.
    }

    /**
     * {@inheritdoc}
     */
    public function setDate(\DateTime $date)
    {
        // TODO: Implement setDate() method.
    }
}
