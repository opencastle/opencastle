<?php
/**
 * Class managing the retrieval, modification and authentication of
 * a Player.
 *
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

/**
 * Class PlayerManager.
 */
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
     * @param EntityManager           $entityManager
     * @param EncoderFactoryInterface $encoderFactory
     */
    public function __construct(
        EntityManager $entityManager,
        EncoderFactoryInterface $encoderFactory
    ) {
        $this->entityManager = $entityManager;
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * Returns a new, empty player object.
     *
     * @return Player
     */
    public function createPlayer()
    {
        $player = new Player();

        return $player;
    }

    /**
     * Persists the changes made to a player in the database.
     *
     * @param Player $player
     * @param bool   $flush
     */
    public function updatePlayer(Player $player, $flush = true)
    {
        if (!empty($player->getPlainPassword())) {
            $this->updatePassword($player);
            $player->eraseCredentials();
        }

        $this->entityManager->persist($player);

        if ($flush) {
            $this->entityManager->flush();
        }
    }

    /**
     * Tries to find a Player in the database
     * based on the username provided.
     *
     * @param string $username
     *
     * @return null|Player
     */
    public function getPlayerByUsername($username)
    {
        return $this->entityManager->getRepository('OpenCastleSecurityBundle:Player')->findOneBy(array(
            'username' => $username,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByUsername($username)
    {
        $potentialUser = $this->getPlayerByUsername($username);

        if (empty($potentialUser)) {
            throw new UsernameNotFoundException();
        }

        return $potentialUser;
    }

    /**
     * {@inheritdoc}
     */
    public function refreshUser(UserInterface $user)
    {
        $refreshedUser = $this->getPlayerByUsername($user->getUsername());

        if (null === $refreshedUser) {
            throw new UsernameNotFoundException(
                sprintf('User with usernamr "%s" could not be reloaded.', $user->getUsername())
            );
        }

        return $refreshedUser;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return $class === 'OpenCastle\\SecurityBundle\\Entity\\Player';
    }

    /**
     * Updates the player's password with the one
     * provided in the plainPassword property.
     *
     * @param Player $player
     */
    private function updatePassword(Player $player)
    {
        $encoder = $this->encoderFactory->getEncoder($player);
        $player->setPassword($encoder->encodePassword($player->getPlainPassword(), $player->getSalt()));
    }

    /**
     * Send a validation link to the player.
     *
     * @param Player $player
     *
     * @throws \Exception
     */
    public function sendEmailValidationLink(Player $player)
    {
        if (!filter_var($player->getEmail(), FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('Invalid e-mail provided to player');
        }

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < 100; ++$i) {
            $randstring .= $characters[rand(0, strlen($characters) - 1)];
        }

        $player->setEmailValidationHash($randstring);

        $this->entityManager->flush();

        // require mail template and send the mail
        // TODO: dispatch event to send mail
        /*$message = \Swift_Message::newInstance()
            ->setSubject('OpenCastle - Validation de votre adresse e-mail')
            ->setTo($player->getEmail())
            ->setBody(
                $this->templating->render(
                    'OpenCastleSecurityBundle:Mail:validation_link.html.twig',
                    array('username' => $player->getUsername())
                ),
                'text/html'
            )
        ;

        if ($this->mailer->send($message) < 1) {
            throw new \Exception('Could not send validation e-mail to '.$player->getEmail());
        }*/
    }

    /**
     * Validates a hash received by the player.
     *
     * @param Player $player
     * @param $validationHash
     *
     * @return bool
     */
    public function validateEmail(Player $player, $validationHash)
    {
        if ($player->getEmailValidationHash() === $validationHash) {
            $player->setEmailVerified(true);
            $this->entityManager->flush();

            return true;
        } else {
            return false;
        }
    }
}
