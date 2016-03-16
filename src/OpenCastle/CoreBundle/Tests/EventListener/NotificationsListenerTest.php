<?php
/**
 * Created by PhpStorm.
 * User: zack
 * Date: 16.03.16
 * Time: 21:16
 */

namespace OpenCastle\CoreBundle\Tests\EventListener;

use OpenCastle\CoreBundle\Event\SendNotificationEvent;
use OpenCastle\CoreBundle\EventListener\NotificationsListener;
use Symfony\Component\Templating\EngineInterface;

/**
 * Class NotificationsListenerTest
 * @package OpenCastle\CoreBundle\Tests\EventListener
 */
class NotificationsListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Invalid notification type: 3
     */
    public function testUnsupportedTypeTest()
    {
        $type = 3;
        $template = 'dumytemplate';

        $event = new SendNotificationEvent($type, $template);

        $mailer = $this->getMockBuilder(\Swift_Mailer::class)
            ->disableOriginalConstructor()
            ->getMock();
        $templating = $this->getMock(EngineInterface::class);

        $listener = new NotificationsListener($mailer, $templating);
        $listener->sendNotification($event);
    }
}
