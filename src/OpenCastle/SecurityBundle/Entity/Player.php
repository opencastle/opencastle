<?php

namespace OpenCastle\SecurityBundle\Entity;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use OpenCastle\CoreBundle\Entity\PlayerStat;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class that represents a Player in the game.
 *
 * @ORM\Table(name="player")
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
     * @ORM\Column(name="email", type="string", length=254, nullable=true)
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(name="emailValidationHash", type="string", length=100, nullable=true)
     */
    private $emailValidationHash;

    /**
     * @var bool
     * @ORM\Column(name="email_verified", type="boolean")
     */
    private $emailVerified;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime")
     */
    private $creationDate;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="OpenCastle\SecurityBundle\Entity\PlayerGroup", inversedBy="players")
     * @ORM\JoinTable(name="player_player_groups")
     */
    private $groups;

    /**
     * @var int
     * @ORM\Column(name="age", type="integer")
     */
    private $age;

    /**
     * @var float
     * @ORM\Column(name="money", type="float")
     */
    private $money;

    /**
     * @ORM\OneToMany(targetEntity="OpenCastle\CoreBundle\Entity\PlayerStat", mappedBy="player", orphanRemoval=true)
     */
    private $stats;

    /**
     * Player constructor.
     */
    public function __construct()
    {
        $this->groups = new ArrayCollection();
        $this->creationDate = new \DateTime();
        $this->age = 16; // We begin at 16 years old
        $this->emailVerified = false;
        $this->money = 500.0; // begin with 500
        $this->stats = new ArrayCollection();
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
     * Get salt.
     *
     * @return string
     */
    public function getSalt()
    {
        return '';
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
     * @return string
     */
    public function getEmailValidationHash()
    {
        return $this->emailValidationHash;
    }

    /**
     * @param string $emailValidationHash
     *
     * @return Player
     */
    public function setEmailValidationHash($emailValidationHash)
    {
        $this->emailValidationHash = $emailValidationHash;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmailVerified()
    {
        return $this->emailVerified;
    }

    /**
     * @param mixed $emailVerified
     *
     * @return Player
     */
    public function setEmailVerified($emailVerified)
    {
        $this->emailVerified = $emailVerified;

        return $this;
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
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @param \DateTime $creationDate
     *
     * @return Player
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param int $age
     *
     * @return Player
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
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

    /**
     * @return float
     */
    public function getMoney()
    {
        return $this->money;
    }

    /**
     * @param float $money
     *
     * @return Player
     */
    public function setMoney($money)
    {
        $this->money = $money;

        return $this;
    }

    /**
     * @param PlayerStat $stat
     *
     * @return $this
     */
    public function addStat(PlayerStat $stat)
    {
        if (!$this->stats->contains($stat)) {
            $this->stats->add($stat);
            $stat->setPlayer($this);
        }

        return $this;
    }

    /**
     * @param PlayerStat $stat
     *
     * @return $this
     */
    public function removeStat(PlayerStat $stat)
    {
        if ($this->stats->contains($stat)) {
            $this->stats->removeElement($stat);
            $stat->setPlayer(null);
        }

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getStats()
    {
        return $this->stats;
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function getStatByFullName($name)
    {
        return $this->getStatBy('fullName', $name);
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function getStatByShortName($name)
    {
        return $this->getStatBy('shortName', $name);
    }

    /**
     * @param $key
     * @param $value
     *
     * @return mixed
     */
    private function getStatBy($key, $value)
    {
        return $this->stats->matching(
            Criteria::create()->where(Criteria::expr()->eq('stat.shortName', $name))
        )->first();
    }
}
