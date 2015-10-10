<?php
/**
 * Created by PhpStorm.
 * User: zack
 * Date: 08.10.15
 * Time: 16:42
 */

namespace OpenCastle\SecurityBundle\Security;
use Doctrine\ORM\EntityManager;
use OpenCastle\SecurityBundle\Entity\Player;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;


class PlayerManager implements UserProviderInterface
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * @var \Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface
     */
    private $encoderFactory;

    /**
     * @param EntityManager $entityManager
     * @param EncoderFactoryInterface $encoderFactory
     */
    public function __construct(EntityManager $entityManager, EncoderFactoryInterface $encoderFactory)
    {
        $this->entityManager = $entityManager;
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * Returns a new, empty player object
     *
     * @return Player
     */
    public function createPlayer()
    {
        $player = new Player();
        $player->setSalt($this->generateSalt());

        return $player;
    }

    /**
     * Persists the changes made to a player in the database
     *
     * @param Player $player
     * @param bool flush
     */
    public function updatePlayer(Player $player, $flush = true)
    {
        if(!empty($player->getPlainPassword()))
        {
            $this->updatePassword($player);
        }

        $this->entityManager->persist($player);

        if($flush)
            $this->entityManager->flush();
    }

    /**
     * Tries to find a Player in the database
     * based on the username provided
     *
     * @param string $username
     *
     * @return null|Player
     */
    public function getPlayerByUsername($username)
    {
        return $this->entityManager->getRepository('OpenCastleSecurityBundle:Player')->findOneBy(array('username' => $username));
    }

    /**
     * @inheritdoc
     */
    public function loadUserByUsername($username)
    {
        $potentialUser = $this->getPlayerByUsername($username);

        if(empty($potentialUser))
            throw new UsernameNotFoundException();

        return $potentialUser;
    }

    /**
     * @inheritdoc
     */
    public function refreshUser(UserInterface $user)
    {
        $refreshedUser = $this->getPlayerByUsername($user->getUsername());

        if (null === $refreshedUser) {
            throw new UsernameNotFoundException(sprintf('User with usernamr "%s" could not be reloaded.', $user->getUsername()));
        }

        return $refreshedUser;
    }

    /**
     * @inheritdoc
     */
    public function supportsClass($class)
    {
        return $class === 'OpenCastle\\SecurityBundle\\Entity\\Player';
    }

    /**
     * Generates a random salt
     *
     * @return string
     */
    private function generateSalt()
    {
        return sha1(strval(mt_rand()));
    }

    /**
     * Updates the player's password with the one
     * provided in the plainPassword property
     *
     * @param Player $player
     */
    private function updatePassword(Player $player)
    {
        $encoder = $this->encoderFactory->getEncoder($player);
        $player->setPassword($encoder->encodePassword($player->getPlainPassword(), $player->getSalt()));
    }

}