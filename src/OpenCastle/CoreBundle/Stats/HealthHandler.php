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
 * Handles Health of the player
 * WARNING: Has to be processed last.
 *
 * Class HealthHandler
 */
class HealthHandler extends BaseStatHandler
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'hp';
    }

    /**
     * {@inheritdoc}
     */
    public function dailyUpdate(Player $player)
    {
        $thirst = $player->getStat('thirst');
        $hunger = $player->getStat('hunger');

        $modifier = $this->getModifier($thirst->getValue()) + $this->getModifier($hunger->getValue());
        $this->decrease(ceil(0.584 * $player->getAge()), $player);
        $this->add($modifier, $player);
    }

    /**
     * {@inheritdoc}
     */
    public function isDead(Player $player)
    {
        $health = $player->getStat('hp');
        $now = new \DateTime();

        return $health->getValue() <= 0 && $health->getLastUpdated()->diff($now, true)->days >= 1;
    }
}
