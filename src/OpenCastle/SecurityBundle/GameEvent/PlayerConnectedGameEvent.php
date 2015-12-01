<?php
/**
 * Created by PhpStorm.
 * User: zack
 * Date: 30.11.15
 * Time: 22:50
 */

namespace OpenCastle\SecurityBundle\GameEvent;

use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\Event;
use OpenCastle\CoreBundle\GameEvent\GameEventInterface;
use OpenCastle\SecurityBundle\Entity\Player;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class PlayerConnectedGameEvent extends Event implements GameEventInterface
{
    /**
     * @var Player
     */
    private $receiver;

    /**
     * @var \Datetime
     */
    private $date;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(TokenStorageInterface $tokenStorage, EntityManager $em)
    {
        $this->tokenStorage = $tokenStorage;
        $this->em = $em;
    }

    /**
     * @inheritDoc
     */
    public function setSender($sender)
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getSender()
    {
        return null;
    }

    /**
     * Set the receiver of the event, the connected player
     *
     * @param integer $receiver
     * @return PlayerConnectedGameEvent
     */
    public function setReceiver($receiver)
    {
        $this->receiver = $this->em->getRepository('OpenCastleSecurityBundle:Player')->find($receiver);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getReceiver()
    {
        return $this->receiver->getId();
    }

    /**
     * @inheritDoc
     */
    public function getType()
    {
        return 'opencastle.user_connected';
    }

    /**
     * @inheritDoc
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * @inheritDoc
     */
    public function getMessage()
    {
        $message = '';

        if ($this->tokenStorage->getToken()->getUsername() === $this->receiver->getUsername()) {
            $message .= 'Vous vous êtes connecté ';
        } else {
            $message .= sprintf("%s s'est connecté ", $this->receiver->getUsername());
        }

        return sprintf($message."le %s à %s", $this->date->format('d/m/Y'), $this->date->format('H:i'));
    }
}