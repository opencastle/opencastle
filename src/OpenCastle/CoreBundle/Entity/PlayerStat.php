<?php

namespace OpenCastle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use OpenCastle\SecurityBundle\Entity\Player;

/**
 * PlayerStat.
 *
 * @ORM\Table(name="player_stat")
 * @ORM\Entity(repositoryClass="OpenCastle\CoreBundle\Entity\PlayerStatRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class PlayerStat
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="value", type="integer")
     */
    private $value;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastUpdated", type="date")
     */
    private $lastUpdated;

    /**
     * @var Player
     * @ORM\ManyToOne(targetEntity="OpenCastle\SecurityBundle\Entity\Player", inversedBy="stats")
     */
    private $player;

    /**
     * @var Stat
     * @ORM\ManyToOne(targetEntity="OpenCastle\CoreBundle\Entity\Stat")
     */
    private $stat;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set value.
     *
     * @param int $value
     *
     * @return PlayerStat
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value.
     *
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return \DateTime
     */
    public function getLastUpdated()
    {
        return $this->lastUpdated;
    }

    /**
     * @param \DateTime $lastUpdated
     * @return PlayerStat
     */
    public function setLastUpdated(\DateTime $lastUpdated)
    {
        $this->lastUpdated = $lastUpdated;
        return $this;
    }

    /**s
     * @return mixed
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * @param mixed $player
     *
     * @return PlayerStat
     */
    public function setPlayer($player)
    {
        $this->player = $player;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStat()
    {
        return $this->stat;
    }

    /**
     * @param mixed $stat
     *
     * @return PlayerStat
     */
    public function setStat($stat)
    {
        $this->stat = $stat;

        return $this;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function updateStat()
    {
        $this->lastUpdated = new \DateTime();
    }
}
