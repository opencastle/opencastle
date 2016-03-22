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
     * @throws AlreadyExistingHandlerException
     * @throws InvalidNameException
     */
    public function addHandler(StatHandlerInterface $handler)
    {
        if (!is_string($handler->getName()) || empty($handler->getName())) {
            throw new InvalidNameException($handler->getName());
        }

        if (!empty($this->handlers[$handler->getName()])) {
            throw new AlreadyExistingHandlerException($handler->getName());
        }

        $this->handlers[$handler->getName()] = $handler;
    }

    /**
     * Calls every handler's dailyUpdate method
     * @param Player $player
     */
    public function dailyUpdate(Player $player)
    {
        foreach ($this->handlers as $handler) {
            /** @var StatHandlerInterface $handler */
            $handler->dailyUpdate($player);
        }
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset)
    {
        return (!empty($this->handlers[$offset]));
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        return $this->handlers[$offset];
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
