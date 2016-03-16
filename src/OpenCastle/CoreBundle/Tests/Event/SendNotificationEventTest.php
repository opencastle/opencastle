<?php
/**
 * Created by PhpStorm.
 * User: zack
 * Date: 16.03.16
 * Time: 21:13.
 */

namespace OpenCastle\CoreBundle\Tests\Event;

use OpenCastle\CoreBundle\Event\SendNotificationEvent;

/**
 * Class SendNotificationEventTest.
 */
class SendNotificationEventTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Invalid type given: abc
     */
    public function testConstructInvalidType()
    {
        $type = 'abc';
        $template = '';

        $event = new SendNotificationEvent($type, $template);
    }
    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Invalid template given: 127
     */
    public function testConstructInvalidTemplate()
    {
        $type = 1;
        $template = 127;

        $event = new SendNotificationEvent($type, $template);
    }
}
