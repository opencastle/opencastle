<?php
/**
 * Created by PhpStorm.
 * User: zack
 * Date: 01.12.15
 * Time: 19:30.
 */
namespace OpenCastle\CoreBundle\Tests\GameEvent;

use OpenCastle\CoreBundle\Entity\GameEventLog;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use OpenCastle\CoreBundle\GameEvent\GameEventHandler;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class GameEventHandlerTest
 * @package OpenCastle\CoreBundle\Tests\GameEvent
 */
class GameEventHandlerTest extends KernelTestCase
{
    /**
     * @var GameEventHandler
     */
    private $eventHandler;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    public function setUp()
    {
        self::bootKernel();

        $this->eventDispatcher = static::$kernel
            ->getContainer()
            ->get('event_dispatcher');
    }

    public function testGetSubscribedEvents()
    {
        $this->eventHandler = static::$kernel
            ->getContainer()
            ->get('opencastle_core.game_event_handler');

        $events = $this->eventHandler->getSubscribedEvents();

        $this->assertEquals(['opencastle.game_event' => 'onGameEventReceived'], $events);
    }

    public function testOnGameEventReceivedWrongTypeEvent()
    {
        $this->eventHandler = static::$kernel
            ->getContainer()
            ->get('opencastle_core.game_event_handler');

        $this->setExpectedException('Exception');

        $event = new GameEventInterfaceTest();

        $this->eventDispatcher->dispatch('opencastle.game_event', $event);

        $event = new GameEventInterfaceTest(123);

        $this->eventDispatcher->dispatch('opencastle.game_event', $event);
    }

    public function testOnGameEventReceivedWrongSenderOrReceiver()
    {
        $this->setExpectedException('Exception');

        $repository = $this
            ->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        $repository
            ->expects($this->never())
            ->method('persist')
            ->will($this->returnValue(null));

        $repository
            ->expects($this->never())
            ->method('flush')
            ->will($this->returnValue(null));

        $validator = self::$kernel->getContainer()->get('validator');

        $event = new GameEventInterfaceTest('test');

        /** @noinspection PhpParamsInspection */
        $eventHandler = new GameEventHandler($repository, $validator);
        $eventHandler->addEvent($event);

        $eventHandler->onGameEventReceived($event);
    }

    public function testOnGameEventReceivedOk()
    {
        $repository = $this
            ->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        $repository
            ->expects($this->once())
            ->method('persist')
            ->will($this->returnValue(null));

        $repository
            ->expects($this->once())
            ->method('flush')
            ->will($this->returnValue(null));

        $validator = self::$kernel->getContainer()->get('validator');

        $event2 = new GameEventInterfaceTest('test2');
        $event2->setSender(1);

        /** @noinspection PhpParamsInspection */
        $eventHandler = new GameEventHandler($repository, $validator);
        $eventHandler->addEvent($event2);

        $eventHandler->onGameEventReceived($event2);
    }

    public function testReconstructWrongType()
    {
        $this->eventHandler = static::$kernel
            ->getContainer()
            ->get('opencastle_core.game_event_handler');

        $this->setExpectedException('Exception');

        $log = new GameEventLog();
        $log->setType('test');

        $this->eventHandler->reconstruct($log);
    }

    public function testReconstructOk()
    {
        $repository = $this
        ->getMockBuilder('\Doctrine\ORM\EntityManager')
        ->disableOriginalConstructor()
        ->getMock();

        $repository
            ->expects($this->never())
            ->method('persist')
            ->will($this->returnValue(null));

        $repository
            ->expects($this->never())
            ->method('flush')
            ->will($this->returnValue(null));

        $validator = self::$kernel->getContainer()->get('validator');

        $event = new GameEventInterfaceTest('test');
        $event->setSender(1);

        /** @noinspection PhpParamsInspection */
        $eventHandler = new GameEventHandler($repository, $validator);
        $eventHandler->addEvent($event);

        $log = new GameEventLog();
        $log->setType('test');

        $event = $eventHandler->reconstruct($log);

        $this->assertInstanceOf('\\OpenCastle\\CoreBundle\\Tests\\GameEvent\\GameEventInterfaceTest', $event);
    }
}
