<?php

namespace OpenCastle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use OpenCastle\CoreBundle\Validator\Constraints as CoreAssert;

/**
 * GameEventLog
 * Represents a persistence of an event.
 * CAUTION: Either senderId or receiverId are optionnal, but at least one must be specified.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="OpenCastle\CoreBundle\Entity\GameEventLogRepository")
 * @CoreAssert\HasSenderOrReceiver
 */
class GameEventLog
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="sender_id", type="integer", nullable=true)
     */
    private $senderId;

    /**
     * @var int
     *
     * @ORM\Column(name="receiver_id", type="integer", nullable=true)
     */
    private $receiverId;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;
    /**
     * @var \Datetime
     *
     * @ORM\Column(name="event_date", type="datetime")
     */
    private $date;

    /**
     * GameEventLog constructor.
     */
    public function __construct()
    {
        $this->date = new \DateTime();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set senderId.
     *
     * @param int $senderId
     *
     * @return GameEventLog
     */
    public function setSenderId($senderId)
    {
        $this->senderId = $senderId;

        return $this;
    }

    /**
     * Get senderId.
     *
     * @return int
     */
    public function getSenderId()
    {
        return $this->senderId;
    }

    /**
     * Set receiverId.
     *
     * @param int $receiverId
     *
     * @return GameEventLog
     */
    public function setReceiverId($receiverId)
    {
        $this->receiverId = $receiverId;

        return $this;
    }

    /**
     * Get receiverId.
     *
     * @return int
     */
    public function getReceiverId()
    {
        return $this->receiverId;
    }

    /**
     * Set type.
     *
     * @param string $type
     *
     * @return GameEventLog
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set date.
     *
     * @param \Datetime $date
     *
     * @return GameEventLog
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return \Datetime
     */
    public function getDate()
    {
        return $this->date;
    }
}
