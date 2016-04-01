<?php
/**
 * Created by PhpStorm.
 * User: zack
 * Date: 13.03.16
 * Time: 14:18.
 */

namespace OpenCastle\CoreBundle\EventListener;

use OpenCastle\CoreBundle\Event\Events;
use OpenCastle\CoreBundle\Event\SendNotificationEvent;
use Symfony\Component\Templating\EngineInterface;

/**
 * Class NotificationListener.
 */
class NotificationsListener
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var EngineInterface
     */
    private $templating;

    /**
     * NotificationsListener constructor.
     *
     * @param \Swift_Mailer   $mailer
     * @param EngineInterface $templating
     */
    public function __construct(\Swift_Mailer $mailer, EngineInterface $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    /**
     * @param SendNotificationEvent $event
     *
     * @throws \Exception
     */
    public function sendNotification(SendNotificationEvent $event)
    {
        switch ($event->getType()) {
            case Events::SEND_MAIL:
                $data = $event->getData();
                $message = \Swift_Message::newInstance()
                    ->setTo($data['to'])
                    ->setSubject($data['subject'])
                    ->setBody($this->templating->render($event->getTemplate(), $data));

                if ($this->mailer->send($message) < 1) {
                    throw new \Exception('Could not send message to '.$data['to']);
                }
                // @codeCoverageIgnoreStart
                break;
            // @codeCoverageIgnoreEnd
            default:
                throw new \Exception('Invalid notification type: '.$event->getType());
        }

    // @codeCoverageIgnoreStart
    }
    // @codeCoverageIgnoreEnd
}
