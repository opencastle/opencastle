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
 * Handles Thirst of the player.
 *
 * Class ThirstHandler
 */
class ThirstHandler extends BaseStatHandler
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'thirst';
    }

    /**
     * {@inheritdoc}
     */
    public function dailyUpdate(Player $player)
    {
        $this->decrease(11, $player);
    }

    /**
     * {@inheritdoc}
     */
    public function isDead(Player $player)
    {
        $thirst = $player->getStat('thirst');
        $now = new \DateTime();

        return $thirst->getValue() <= 0 && $thirst->getLastUpdated()->diff($now, true)->days >= 3;
    }
}
