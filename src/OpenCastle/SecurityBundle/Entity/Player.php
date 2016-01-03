<?php

namespace OpenCastle\SecurityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class that represents a Player in the game.
 *
 * @ORM\Table(name="players")
 * @ORM\Entity(repositoryClass="OpenCastle\SecurityBundle\Entity\PlayerRepository")
 *
 * @UniqueEntity("username")
 * @UniqueEntity("email")
 */
class Player implements UserInterface
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
     * @ORM\Column(name="username", type="string", length=255)
     *
     * @Assert\NotBlank(groups={"registration"})
     * @Assert\Length(min=5, max=255)
     * @Assert\Regex(pattern="/[a-zA-Z0-9_-]+/")
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=40)
     */
    private $password;

    /**
     * @var string
     *
     * @Assert\NotBlank(groups={"registration"})
     * @Assert\Length(min=5, groups={"registration"})
     */
    private $plainPassword;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=40)
     */
    private $salt;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=254, nullable=true)
     */
    private $email;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="OpenCastle\SecurityBundle\Entity\PlayerGroup", inversedBy="players")
     * @ORM\JoinTable(name="players_have_player_groups")
     * @ORM\JoinColumn(nullable=false)
     */
    private $groups;

    /**
     * Player constructor.
     */
    public function __construct()
    {
        $this->groups = new ArrayCollection();
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
     * Set username.
     *
     * @param string $username
     *
     * @return Player
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password.
     *
     * @param string $password
     *
     * @return Player
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set plainPassword.
     *
     * @param string $plainPassword
     *
     * @return Player
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * Get plainPassword.
     *
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Set salt.
     *
     * @param string $salt
     *
     * @return Player
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt.
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return Player
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Add group.
     *
     * @param PlayerGroup $group
     *
     * @return Player
     */
    public function addGroup(PlayerGroup $group)
    {
        $this->groups->add($group);

        return $this;
    }

    /**
     * Remove group.
     *
     * @param PlayerGroup $group
     *
     * @return Player
     */
    public function removeGroup(PlayerGroup $group)
    {
        $this->groups->removeElement($group);

        return $this;
    }

    /**
     * Set groups.
     *
     * @param ArrayCollection $groups
     *
     * @return Player
     */
    public function setGroups(ArrayCollection $groups)
    {
        $this->groups = $groups;

        return $this;
    }

    /**
     * Get groups.
     *
     * @return ArrayCollection
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        $roles = array();

        foreach ($this->groups as $group) {
            $roles = array_merge($roles, array($group->getRole()));
        }

        return $roles;
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
        $this->setPlainPassword(null);
    }
}
