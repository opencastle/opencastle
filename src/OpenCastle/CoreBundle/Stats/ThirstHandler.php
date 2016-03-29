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
 * Handles Thirst of the player
 *
 * Class ThirstHandler
 * @package OpenCastle\CoreBundle\Stats
 */
class ThirstHandler implements StatHandlerInterface
{
    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'thirst';
    }

    /**
     * @inheritDoc
     */
    public function dailyUpdate(Player $player)
    {
        $this->decrease(11, $player);
    }

    /**
     * @inheritDoc
     */
    public function add($value, Player $player)
    {
        $player->getStat('thirst')->setValue($player->getStat('thirst')->getValue() + $value);
    }

    /**
     * @inheritDoc
     */
    public function decrease($value, Player $player)
    {
        $thirst = $player->getStat('thirst');
        $thirst->setValue($thirst->getValue() - $value);

        if ($thirst->getValue() < 0) {
            $thirst->setValue(0);
        }
    }

    /**
     * @inheritDoc
     */
    public function isDead(Player $player)
    {
        $thirst = $player->getStat('thirst');
        $now = new \DateTime();

        return ($thirst->getValue() <= 0 && $thirst->getLastUpdated()->diff($now, true)->d >= 3 );
    }
}
