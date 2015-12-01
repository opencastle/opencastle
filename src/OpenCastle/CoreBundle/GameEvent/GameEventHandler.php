<?php
/**
 * Created by PhpStorm.
 * User: zack
 * Date: 30.11.15
 * Time: 20:01
 */

namespace OpenCastle\CoreBundle\GameEvent;

use Doctrine\ORM\EntityManager;
use OpenCastle\CoreBundle\Entity\GameEventLog;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class GameEventHandler implements EventSubscriberInterface
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var array
     */
    private $events = array();

    const GAME_EVENT = 'opencastle.game_event';

    /**
     * GameEventHandler constructor.
     * @param EntityManager $manager
     * @param ValidatorInterface $validator
     */
    public function __construct(EntityManager $manager, ValidatorInterface $validator)
    {
        $this->em = $manager;
        $this->validator = $validator;
    }

    /**
     * Add an event to the supported events pool
     * @param GameEventInterface $event
     * @throws \Exception
     */
    public function addEvent(GameEventInterface $event)
    {
        if (!empty($this->events[$event->getType()])) {
            throw new \Exception("Un évènement avec l'identifiant ".$event->getType()." existe déjà.");
        }

        $this->events[$event->getType()] = $event;
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [
          self::GAME_EVENT => 'onGameEventReceived'
        ];
    }

    /**
     * Registers an event in the database
     *
     * @param GameEventInterface $event
     * @throws \Exception
     */
    public function onGameEventReceived(GameEventInterface $event)
    {
        if (empty($this->events[$event->getType()])) {
            throw new \Exception(
                "L'évènement dispatché ".$event->getType()." n'est pas un service taggé \"opencastle.game_event\"."
            );
        }

        if (!is_string($event->getType())) {
            throw new \Exception("Le type de l'évènement doit être une chaîne de caractères.");
        }


        $gameEventLog = new GameEventLog();
        $gameEventLog->setSenderId($event->getSender());
        $gameEventLog->setReceiverId($event->getReceiver());
        $gameEventLog->setType($event->getType());

        $errors = $this->validator->validate($gameEventLog);

        if ($errors->count() > 0) {
            $message = '';
            foreach ($errors as $error) {
                $message .= $error->getMessage()."\r\n";
            }

            throw new \Exception($message);
        }

        $this->em->persist($gameEventLog);
        $this->em->flush();
    }

    /**
     * Reconstructs an event from its GameEventLog entry
     *
     * @param GameEventLog $gameEventLog
     * @return GameEventInterface
     * @throws \Exception
     */
    public function reconstruct(GameEventLog $gameEventLog)
    {
        if (empty($this->events[$gameEventLog->getType()])) {
            throw new \Exception(
                "L'évènement à récupérer ".$gameEventLog->getType()." n'existe pas."
            );
        }

        /** @var GameEventInterface $event */
        $event = clone $this->events[$gameEventLog->getType()];
        $event->setReceiver($gameEventLog->getReceiverId());
        $event->setSender($gameEventLog->getSenderId());
        $event->setDate($gameEventLog->getDate());

        return $event;
    }
}
