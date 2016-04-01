<?php
/**
 * Created by PhpStorm.
 * User: zack
 * Date: 29.03.16
 * Time: 17:45.
 */

namespace OpenCastle\CoreBundle\Stats;

use OpenCastle\SecurityBundle\Entity\Player;

/**
 * Handles Hunger of the player.
 *
 * Class HungerhHandler
 */
class HungerHandler extends BaseStatHandler
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'hunger';
    }

    /**
     * {@inheritdoc}
     */
    public function dailyUpdate(Player $player)
    {
        $this->decrease(7, $player);
    }

    /**
     * {@inheritdoc}
     */
    public function isDead(Player $player)
    {
        $hunger = $player->getStat('hunger');
        $now = new \DateTime();

        return $hunger->getValue() <= 0 && $hunger->getLastUpdated()->diff($now, true)->days >= 3;
    }
}
