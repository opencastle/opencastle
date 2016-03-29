<?php
/**
 * Created by PhpStorm.
 * User: zack
 * Date: 22.03.16
 * Time: 22:05
 */

namespace OpenCastle\CoreBundle\StatHandler;

use OpenCastle\SecurityBundle\Entity\Player;

/**
 * Interface StatHandlerInterface
 * Must be implemented by stat handlers
 * @package OpenCastle\CoreBundle\StatHandler
 */
interface StatHandlerInterface
{
    /**
     * The stat handler name (usually the shortName of the stat handled by the class)
     * @return string
     */
    public function getName();

    /**
     * Updates the stat of a player with the daily algorithm
     * @param Player $player
     */
    public function dailyUpdate(Player $player);

    /**
     * Adds $value to the player's stat
     *
     * @param integer $value
     * @param Player $player
     */
    public function add($value, Player $player);

    /**
     * Substracts $value to the player's stat
     *
     * @param integer $value
     * @param Player $player
     */
    public function decrease($value, Player $player);

    /**
     * Returns true if the player is dead
     *
     * @param Player $player
     * @return boolean
     */
    public function isDead(Player $player);
}
