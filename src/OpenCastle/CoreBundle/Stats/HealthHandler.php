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
 * Handles Health of the player
 * WARNING: Has to be processed last
 *
 * Class HealthHandler
 * @package OpenCastle\CoreBundle\Stats
 */
class HealthHandler implements StatHandlerInterface
{
    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'hp';
    }

    /**
     * @inheritDoc
     */
    public function dailyUpdate(Player $player)
    {
        $health = $player->getStat('hp');
        $thirst = $player->getStat('thirst');
        $hunger = $player->getStat('hunger');

        $modifier = $this->getModifier($thirst->getValue()) + $this->getModifier($hunger->getValue());

        $newHealth = $health->getValue() - ceil(0.584 * $player->getAge()) + $modifier;
        if ($newHealth < 0) {
            $newHealth = 0;
        }

        $health->setValue($newHealth);
    }

    /**
     * returns the positive or negative modifier for the health
     * based on thirst and hunger
     *
     * @param integer $value
     * @return integer,
     */
    private function getModifier($value)
    {
        $value = 10;

        if ($value <= 35) {
            $value = -15;
        } elseif ($value <= 50) {
            $value = -10;
        } elseif ($value <= 75) {
            $value = -5;
        } elseif ($value <= 95) {
            $value = 5;
        }

        return $value;
    }

    /**
     * @inheritDoc
     */
    public function add($value, Player $player)
    {
        $player->getStat('hp')->setValue($player->getStat('hp')->getValue() + $value);
    }

    /**
     * @inheritDoc
     */
    public function decrease($value, Player $player)
    {
        $player->getStat('hp')->setValue($player->getStat('hp')->getValue() - $value);
    }

    /**
     * @inheritDoc
     */
    public function isDead(Player $player)
    {
        $health = $player->getStat('hp');
        $now = new \DateTime();

        return ($health->getValue() <= 0 && $health->getLastUpdated()->diff($now, true)->d >= 1 );
    }
}
