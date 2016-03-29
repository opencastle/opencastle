<?php
/**
 * Created by PhpStorm.
 * User: zack
 * Date: 29.03.16
 * Time: 17:45
 */

namespace OpenCastle\CoreBundle\Stats;

use OpenCastle\CoreBundle\Entity\PlayerStat;
use OpenCastle\CoreBundle\StatHandler\StatHandlerInterface;
use OpenCastle\SecurityBundle\Entity\Player;

/**
 * Handles Hunger of the player
 *
 * Class HungerhHandler
 * @package OpenCastle\CoreBundle\Stats
 */
class HungerHandler implements StatHandlerInterface
{
    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'hunger';
    }

    /**
     * @inheritDoc
     */
    public function dailyUpdate(Player $player)
    {
        $this->decrease(7, $player);
    }

    /**
     * @inheritDoc
     */
    public function add($value, Player $player)
    {
        $player->getStat('hunger')->setValue($player->getStat('hunger')->getValue() + $value);
    }

    /**
     * @inheritDoc
     */
    public function decrease($value, Player $player)
    {
        $hunger = $player->getStat('hunger');
        $hunger->setValue($hunger->getValue() - $value);

        if ($hunger->getValue() < 0) {
            $hunger->setValue(0);
        }
    }

    /**
     * @inheritDoc
     */
    public function isDead(Player $player)
    {
        $hunger = $player->getStat('hunger');
        $now = new \DateTime();

        return ($hunger->getValue() <= 0 && $hunger->getLastUpdated()->diff($now, true)->d >= 3 );
    }
}
