<?php

namespace OpenCastle\SecurityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\Role\RoleInterface;

/**
 * Class representing a group a Player belongs to.
 *
 * @ORM\Table(name="player_group")
 * @ORM\Entity(repositoryClass="OpenCastle\SecurityBundle\Entity\PlayerGroupRepository")
 *
 * @UniqueEntity("name")
 */
class PlayerGroup implements RoleInterface
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="OpenCastle\SecurityBundle\Entity\Player", mappedBy="groups")
     */
    private $players;

    /**
     * PlayerGroup constructor.
     */
    public function __construct()
    {
        $this->players = new ArrayCollection();
    }

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
     * Set name.
     *
     * @param string $name
     *
     * @return PlayerGroup
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get players.
     *
     * @return ArrayCollection
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * {@inheritdoc}
     */
    public function getRole()
    {
        return $this->name;
    }
}
