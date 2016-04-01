<?php
/**
 * Created by PhpStorm.
 * User: zack
 * Date: 31.03.16
 * Time: 01:24.
 */

namespace OpenCastle\CoreBundle\Tests\StatHandler;

use OpenCastle\CoreBundle\StatHandler\StatHandlerChain;
use OpenCastle\CoreBundle\Stats\BaseStatHandler;
use OpenCastle\SecurityBundle\Entity\Player;

class StatHandlerChainTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException OpenCastle\CoreBundle\StatHandler\Exception\InvalidNameException
     */
    public function testAddHandlerInvalidName()
    {
        $handlerMock = $this->getMock(BaseStatHandler::class);
        $handlerMock->expects($this->exactly(2))
            ->method('getName')
            ->will($this->returnValue(1235));

        $chain = new StatHandlerChain();
        $chain->addHandler($handlerMock);
    }
    /**
     * @expectedException OpenCastle\CoreBundle\StatHandler\Exception\AlreadyExistingHandlerException
     */
    public function testAddHandlerAlreadyExisting()
    {
        $handlerMock = $this->getMock(BaseStatHandler::class);
        $handlerMock->expects($this->exactly(8))
            ->method('getName')
            ->will($this->returnValue('test'));

        $chain = new StatHandlerChain();
        $chain->addHandler($handlerMock);
        $chain->addHandler($handlerMock);
    }

    public function testArrayAccessMethods()
    {
        $handlerMock = $this->getMock(BaseStatHandler::class);
        $handlerMock->expects($this->exactly(4))
            ->method('getName')
            ->will($this->returnValue('test'));

        $chain = new StatHandlerChain();
        $chain->addHandler($handlerMock);

        $this->assertTrue(!empty($chain['test']));

        $test = $chain['test'];
        $this->assertTrue(BaseStatHandler::class === get_parent_class($test));

        $this->assertTrue(empty($chain['test1']));
    }

    public function testDailyUpdate()
    {
        $handlerMock = $this->getMock(BaseStatHandler::class);
        $handlerMock->expects($this->exactly(4))
            ->method('getName')
            ->will($this->returnValue('test'));
        $handlerMock->expects($this->once())
            ->method('dailyUpdate')
            ->will($this->returnValue(null));
        $handlerMock->expects($this->once())
            ->method('isDead')
            ->will($this->returnValue(true));

        $player = new Player();

        $chain = new StatHandlerChain();
        $chain->addHandler($handlerMock);
        $chain->dailyUpdate($player);

        $this->assertTrue($player->getDead());
    }
}
