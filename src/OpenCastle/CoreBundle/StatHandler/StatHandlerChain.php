<?php
/**
 * Created by PhpStorm.
 * User: zack
 * Date: 22.03.16
 * Time: 21:56
 */

namespace OpenCastle\CoreBundle\StatHandler;

use OpenCastle\CoreBundle\StatHandler\Exception\AlreadyExistingHandlerException;
use OpenCastle\CoreBundle\StatHandler\Exception\InvalidNameException;
use OpenCastle\SecurityBundle\Entity\Player;

/**
 * Holds reference of all the Players' Stat Handlers
 * Class StatHandlerChain
 * @package OpenCastle\CoreBundle\StatHandler
 */
class StatHandlerChain implements \ArrayAccess
{
    /** @var array */
    private $handlers;

    /**
     * Automatically called by the compilerpass
     * @param StatHandlerInterface $handler
     * @param integer $priority
     * @throws AlreadyExistingHandlerException
     * @throws InvalidNameException
     */
    public function addHandler(StatHandlerInterface $handler, $priority = 0)
    {
        $priority = intval($priority);

        if (!is_string($handler->getName()) || empty($handler->getName())) {
            throw new InvalidNameException($handler->getName());
        }

        if (!empty($this->handlers[$handler->getName()])) {
            throw new AlreadyExistingHandlerException($handler->getName());
        }

        $this->handlers[$handler->getName()] = array($handler, $priority);
        $this->sort();
    }

    /**
     * Sorts the list of handlers by priority
     * Higher priority = faster execution
     */
    private function sort()
    {
        usort($this->handlers, function ($a, $b) {

            if ($a[1] === $b[1]) {
                return 0;
            }

            return ($a[1] > $b[1]) ? -1 : 1;
        });
    }

    /**
     * Calls every handler's dailyUpdate method
     * @param Player $player
     */
    public function dailyUpdate(Player $player)
    {
        foreach ($this->handlers as $key => $handler) {
            $handler[0]->dailyUpdate($player);

            $player->setDead($handler[0]->isDead($player));
        }
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset)
    {
        return (!empty($this->handlers[$offset]) && is_array($this->handlers[$offset]));
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        return $this->handlers[$offset][0];
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        // do nothing
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset)
    {
        // do nothing
    }
}
