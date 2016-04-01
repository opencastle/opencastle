<?php
/**
 * Created by PhpStorm.
 * User: zack
 * Date: 31.03.16
 * Time: 22:54.
 */

namespace OpenCastle\CoreBundle\Stats;

use OpenCastle\SecurityBundle\Entity\Player;

/**
 * Class that must be implemented by all stats
 * Class BaseStatHandler.
 */
abstract class BaseStatHandler
{
    /**
     * The stat handler name (usually the shortName of the stat handled by the class).
     *
     * @return string
     */
    abstract public function getName();

    /**
     * Updates the stat of a player with the daily algorithm.
     *
     * @param Player $player
     */
    abstract public function dailyUpdate(Player $player);

    /**
     * returns the positive or negative modifier for the health
     * based on thirst and hunger.
     *
     * @param int $value
     *
     * @return integer
     */
    protected function getModifier($value)
    {
        $modifier = 10;

        if ($value <= 35) {
            $modifier = -15;
        } elseif ($value <= 50) {
            $modifier = -10;
        } elseif ($value <= 75) {
            $modifier = -5;
        } elseif ($value <= 95) {
            $modifier = 5;
        }

        return $modifier;
    }

    /**
     * Adds $value to the player's stat.
     *
     * @param int    $value
     * @param Player $player
     */
    public function add($value, Player $player)
    {
        $stat = $player->getStat($this->getName());
        $stat->setValue($player->getStat($this->getName())->getValue() + $value);
        if ($stat->getValue() < 0) {
            $stat->setValue(0);
        }
    }

    /**
     * Substracts $value to the player's stat.
     *
     * @param int    $value
     * @param Player $player
     */
    public function decrease($value, Player $player)
    {
        $stat = $player->getStat($this->getName());
        $stat->setValue($player->getStat($this->getName())->getValue() - $value);
        if ($stat->getValue() < 0) {
            $stat->setValue(0);
        }
    }

    /**
     * Returns true if the player is dead.
     *
     * @param Player $player
     *
     * @return bool
     */
    abstract public function isDead(Player $player);
}
