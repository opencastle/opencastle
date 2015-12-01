<?php
/**
 * Created by PhpStorm.
 * User: zack
 * Date: 30.11.15
 * Time: 20:11
 */

namespace OpenCastle\CoreBundle\GameEvent;

use OpenCastle\CoreBundle\Entity\GameEventLog;

/**
 * Interface GameEventInterface
 *
 * Exposes basic functionnality to extend, in order to create a GameEvent that will be persisted in the database
 *
 * @package OpenCastle\CoreBundle\GameEvent
 */
interface GameEventInterface
{
    /**
     * Set the sender id, it is up to  the event to retrieve entity
     * @param integer $sender
     */
    public function setSender($sender);

    /**
     * Get the event's sender. Must be an entity id or null
     * @return null|integer
     */
    public function getSender();
    /**
     * Set the receiver id, it is up to  the event to retrieve entity
     * @param integer $receiver
     */
    public function setReceiver($receiver);

    /**
     * Get the event's receiver, Must be an entity id or null
     * @return null|integer
     */
    public function getReceiver();

    /**
     * The event type, must be unique
     * @return string
     */
    public function getType();

    /**
     * The message of the event
     * @return string
     */
    public function getMessage();

    /**
     * Set the date of the event, only used on fetch
     * @param \Datetime
     */
    public function setDate(\DateTime $date);
}
