<?php
/**
 * Created by PhpStorm.
 * User: zack
 * Date: 31.03.16
 * Time: 22:42.
 */

namespace OpenCastle\CoreBundle\Tests\Stats;

use OpenCastle\CoreBundle\Entity\PlayerStat;
use OpenCastle\CoreBundle\Entity\Stat;
use OpenCastle\CoreBundle\Stats\ThirstHandler;
use OpenCastle\SecurityBundle\Entity\Player;

class ThirstHandlerTest extends \PHPUnit_Framework_TestCase
{
    private $hpStat;
    private $thirstStat;
    private $hungerStat;
    private $player;

    public function setUp()
    {
        $this->player = new Player();

        $stat = new Stat();
        $stat->setFullName('Santé')->setInitialValue(100)->setShortName('hp');

        $this->hpStat = new PlayerStat();
        $this->hpStat
            ->setStat($stat)
            ->setValue($stat->getInitialValue())
            ->setPlayer($this->player);

        $this->player->addStat($this->hpStat);

        $stat = new Stat();
        $stat->setFullName('Soif')->setInitialValue(80)->setShortName('thirst');

        $this->thirstStat = new PlayerStat();
        $this->thirstStat
            ->setStat($stat)
            ->setValue($stat->getInitialValue())
            ->setPlayer($this->player);

        $this->player->addStat($this->thirstStat);

        $stat = new Stat();
        $stat->setFullName('Faim')->setInitialValue(80)->setShortName('hunger');

        $this->hungerStat = new PlayerStat();
        $this->hungerStat
            ->setStat($stat)
            ->setValue($stat->getInitialValue())
            ->setPlayer($this->player);

        $this->player->addStat($this->hungerStat);
    }

    public function testGetName()
    {
        $handler = new ThirstHandler();
        $this->assertEquals('thirst', $handler->getName());
    }

    public function testDailyUpdateThirstMustEqual89()
    {
        $this->player->getStat('thirst')->setValue(100);

        $handler = new ThirstHandler();
        $handler->dailyUpdate($this->player);

        $this->assertEquals(89, $this->player->getStat('thirst')->getValue());
    }

    public function testDailyUpdateThirstMustEqual0()
    {
        $this->player->getStat('thirst')->setValue(0);

        $handler = new ThirstHandler();
        $handler->dailyUpdate($this->player);

        $this->assertEquals(0, $this->player->getStat('thirst')->getValue());
    }

    public function testIsDeadFalse()
    {
        $this->player->getStat('thirst')->setValue(70);

        $handler = new ThirstHandler();
        $handler->dailyUpdate($this->player);

        $this->assertFalse($this->player->getDead());
    }

    public function testIsDeadTrue()
    {
        $date = \DateTime::createFromFormat('Y-m-d', '2015-01-01');
        $this->player->getStat('thirst')->setValue(0)->setLastUpdated($date);

        $handler = new ThirstHandler();
        $handler->dailyUpdate($this->player);
        $this->player->setDead($handler->isDead($this->player));

        $this->assertTrue($this->player->getDead());
    }
}
