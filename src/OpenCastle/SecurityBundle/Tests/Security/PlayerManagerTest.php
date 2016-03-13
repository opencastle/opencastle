<?php
/**
 * PlayerManager unit test class.
 *
 * User: zack
 * Date: 11.10.15
 * Time: 12:51
 */

namespace OpenCastle\SecurityBundle\Tests\Security;

use OpenCastle\CoreBundle\EventListener\NotificationsListener;
use OpenCastle\SecurityBundle\Entity\Player;
use OpenCastle\SecurityBundle\Security\PlayerManager;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Templating\EngineInterface;

/**
 * Class PlayerManagerTest.
 */
class PlayerManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testCreatePlayer()
    {
        $encoderFactory = new EncoderFactory(array(
            'opencastle_test' => array(
                'class' => 'OpenCastle\\SecurityBundle\\Entity\\Player',
                'arguments' => array('sha1'),
            ),
        ));

        $entityManager = $this
            ->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        $eventDispatcherMock = $this
            ->getMockBuilder(EventDispatcherInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        /* @noinspection PhpParamsInspection */
        $playerManager = new PlayerManager($entityManager, $encoderFactory, $eventDispatcherMock);

        $player = $playerManager->createPlayer();

        $this->assertInstanceOf('\\OpenCastle\\SecurityBundle\\Entity\\Player', $player);
    }

    public function testUpdatePlayer()
    {
        $encoderFactory = new EncoderFactory(array(
            'OpenCastle\\SecurityBundle\\Entity\\Player' => array(
                'class' => 'Symfony\\Component\\Security\\Core\\Encoder\\MessageDigestPasswordEncoder',
                'arguments' => array('sha1', false),
            ),
        ));

        $entityManager = $this
            ->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        $eventDispatcherMock = $this
            ->getMockBuilder(EventDispatcherInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        /* @noinspection PhpParamsInspection */
        $playerManager = new PlayerManager($entityManager, $encoderFactory, $eventDispatcherMock);

        $player = $playerManager->createPlayer();
        $player->setPlainPassword('test');

        $expectedPassword = $encoderFactory->getEncoder($player)->encodePassword('test', $player->getSalt());

        $playerManager->updatePlayer($player);

        $this->assertNotNull($player->getPassword());
        $this->assertEquals($expectedPassword, $player->getPassword());
        $this->assertNull($player->getPlainPassword());
    }

    public function testGetPlayerByUsername()
    {
        $encoderFactory = new EncoderFactory(array(
            'OpenCastle\\SecurityBundle\\Entity\\Player' => array(
                'class' => 'Symfony\\Component\\Security\\Core\\Encoder\\MessageDigestPasswordEncoder',
                'arguments' => array('sha1', false),
            ),
        ));

        $player = new Player();
        $player->setUsername('testing');

        $playerRepository = $this
            ->getMockBuilder('\Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $playerRepository->expects($this->once())
            ->method('findOneBy')
            ->will($this->returnValue($player));

        $entityManager = $this
            ->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        $entityManager->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($playerRepository));

        $eventDispatcherMock = $this
            ->getMockBuilder(EventDispatcherInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        /* @noinspection PhpParamsInspection */
        $playerManager = new PlayerManager($entityManager, $encoderFactory, $eventDispatcherMock);

        $returnedPlayer = $playerManager->getPlayerByUsername('testing');

        $this->assertSame($player, $returnedPlayer);
    }

    public function testLoadUserByUsername()
    {
        $encoderFactory = new EncoderFactory(array(
            'OpenCastle\\SecurityBundle\\Entity\\Player' => array(
                'class' => 'Symfony\\Component\\Security\\Core\\Encoder\\MessageDigestPasswordEncoder',
                'arguments' => array('sha1', false),
            ),
        ));

        $player = new Player();
        $player->setUsername('testing');

        $playerRepository = $this
            ->getMockBuilder('\Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $playerRepository->expects($this->once())
            ->method('findOneBy')
            ->will($this->returnValue($player));

        $entityManager = $this
            ->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        $entityManager->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($playerRepository));

        $eventDispatcherMock = $this
            ->getMockBuilder(EventDispatcherInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        /* @noinspection PhpParamsInspection */
        $playerManager = new PlayerManager($entityManager, $encoderFactory, $eventDispatcherMock);

        $returnedPlayer = $playerManager->loadUserByUsername($player->getUsername());

        $this->assertSame($player, $returnedPlayer);
    }

    /**
     * @expectedException \Symfony\Component\Security\Core\Exception\UsernameNotFoundException
     */
    public function testLoadUserByUsernameNonExistent()
    {
        $encoderFactory = new EncoderFactory(array(
            'OpenCastle\\SecurityBundle\\Entity\\Player' => array(
                'class' => 'Symfony\\Component\\Security\\Core\\Encoder\\MessageDigestPasswordEncoder',
                'arguments' => array('sha1', false),
            ),
        ));

        $player = new Player();
        $player->setUsername('testing');

        $playerRepository = $this
            ->getMockBuilder('\Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $playerRepository->expects($this->once())
            ->method('findOneBy')
            ->will($this->returnValue(null));

        $entityManager = $this
            ->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        $entityManager->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($playerRepository));

        $eventDispatcherMock = $this
            ->getMockBuilder(EventDispatcherInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        /* @noinspection PhpParamsInspection */
        $playerManager = new PlayerManager($entityManager, $encoderFactory, $eventDispatcherMock);

        $playerManager->loadUserByUsername($player->getUsername());
    }

    public function testRefreshUser()
    {
        $encoderFactory = new EncoderFactory(array(
            'OpenCastle\\SecurityBundle\\Entity\\Player' => array(
                'class' => 'Symfony\\Component\\Security\\Core\\Encoder\\MessageDigestPasswordEncoder',
                'arguments' => array('sha1', false),
            ),
        ));

        $player = new Player();
        $player->setUsername('testing');

        $playerRepository = $this
            ->getMockBuilder('\Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $playerRepository->expects($this->once())
            ->method('findOneBy')
            ->will($this->returnValue($player));

        $entityManager = $this
            ->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        $entityManager->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($playerRepository));

        $eventDispatcherMock = $this
            ->getMockBuilder(EventDispatcherInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        /* @noinspection PhpParamsInspection */
        $playerManager = new PlayerManager($entityManager, $encoderFactory, $eventDispatcherMock);

        $returnedPlayer = $playerManager->refreshUser($player);

        $this->assertSame($player, $returnedPlayer);
    }

    /**
     * @expectedException \Symfony\Component\Security\Core\Exception\UsernameNotFoundException
     */
    public function testRefreshUserWrongUserNonExistent()
    {
        $encoderFactory = new EncoderFactory(array(
            'OpenCastle\\SecurityBundle\\Entity\\Player' => array(
                'class' => 'Symfony\\Component\\Security\\Core\\Encoder\\MessageDigestPasswordEncoder',
                'arguments' => array('sha1', false),
            ),
        ));

        $player = new Player();
        $player->setUsername('testing');

        $playerRepository = $this
            ->getMockBuilder('\Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $playerRepository->expects($this->once())
            ->method('findOneBy')
            ->will($this->returnValue(null));

        $entityManager = $this
            ->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        $entityManager->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($playerRepository));

        $eventDispatcherMock = $this
            ->getMockBuilder(EventDispatcherInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        /* @noinspection PhpParamsInspection */
        $playerManager = new PlayerManager($entityManager, $encoderFactory, $eventDispatcherMock);

        $playerManager->refreshUser($player);
    }

    public function testSupportsClass()
    {
        $encoderFactory = new EncoderFactory(array(
            'OpenCastle\\SecurityBundle\\Entity\\Player' => array(
                'class' => 'Symfony\\Component\\Security\\Core\\Encoder\\MessageDigestPasswordEncoder',
                'arguments' => array('sha1', false),
            ),
        ));

        $player = new Player();
        $player->setUsername('testing');

        $entityManager = $this
            ->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        $eventDispatcherMock = $this
            ->getMockBuilder(EventDispatcherInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        /* @noinspection PhpParamsInspection */
        $playerManager = new PlayerManager($entityManager, $encoderFactory, $eventDispatcherMock);

        $this->assertTrue($playerManager->supportsClass(get_class($player)));
    }

    public function testSupportsClassWrongClass()
    {
        $encoderFactory = new EncoderFactory(array(
            'OpenCastle\\SecurityBundle\\Entity\\Player' => array(
                'class' => 'Symfony\\Component\\Security\\Core\\Encoder\\MessageDigestPasswordEncoder',
                'arguments' => array('sha1', false),
            ),
        ));

        $player = new Player();
        $player->setUsername('testing');

        $entityManager = $this
            ->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        $eventDispatcherMock = $this
            ->getMockBuilder(EventDispatcherInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        /* @noinspection PhpParamsInspection */
        $playerManager = new PlayerManager($entityManager, $encoderFactory, $eventDispatcherMock);

        $this->assertFalse($playerManager->supportsClass('DummyFalseClass'));
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Could not send message to test@test.com
     */
    public function testSendEmailValidationLinkUnsuccessful()
    {
        $encoderFactory = new EncoderFactory(array(
            'OpenCastle\\SecurityBundle\\Entity\\Player' => array(
                'class' => 'Symfony\\Component\\Security\\Core\\Encoder\\MessageDigestPasswordEncoder',
                'arguments' => array('sha1', false),
            ),
        ));

        $player = new Player();
        $player->setUsername('testing');
        $player->setEmail('test@test.com');

        $entityManager = $this
            ->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        $entityManager->expects($this->once())
            ->method('flush')
            ->will($this->returnValue(null));

        $mailer = $this
            ->getMockBuilder(\Swift_Mailer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $templating = $this
            ->getMockBuilder(EngineInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $eventDispatcher = new EventDispatcher();
        $eventDispatcher->addListener('opencastle.send_notification', array(
            new NotificationsListener($mailer, $templating),
            'sendNotification'
        ));

        /* @noinspection PhpParamsInspection */
        $playerManager = new PlayerManager($entityManager, $encoderFactory, $eventDispatcher);
        $playerManager->sendEmailValidationLink($player);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Invalid e-mail provided to player
     */
    public function testSendEmailValidationLinkNoEmail()
    {
        $encoderFactory = new EncoderFactory(array(
            'OpenCastle\\SecurityBundle\\Entity\\Player' => array(
                'class' => 'Symfony\\Component\\Security\\Core\\Encoder\\MessageDigestPasswordEncoder',
                'arguments' => array('sha1', false),
            ),
        ));

        $player = new Player();
        $player->setUsername('testing');

        $entityManager = $this
            ->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        $eventDispatcherMock = $this
            ->getMockBuilder(EventDispatcherInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        /* @noinspection PhpParamsInspection */
        $playerManager = new PlayerManager($entityManager, $encoderFactory, $eventDispatcherMock);
        $playerManager->sendEmailValidationLink($player);
    }

    public function testSendEmailValidationLinkSuccess()
    {
        $encoderFactory = new EncoderFactory(array(
            'OpenCastle\\SecurityBundle\\Entity\\Player' => array(
                'class' => 'Symfony\\Component\\Security\\Core\\Encoder\\MessageDigestPasswordEncoder',
                'arguments' => array('sha1', false),
            ),
        ));

        $player = new Player();
        $player->setUsername('testing');
        $player->setEmail('test@test.com');

        $entityManager = $this
            ->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        $entityManager->expects($this->once())
            ->method('flush')
            ->will($this->returnValue(null));

        $eventDispatcherMock = $this
            ->getMockBuilder(EventDispatcherInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        /* @noinspection PhpParamsInspection */
        $playerManager = new PlayerManager($entityManager, $encoderFactory, $eventDispatcherMock);
        $playerManager->sendEmailValidationLink($player);
    }

    public function testValidateEmailWrongHash()
    {
        $encoderFactory = new EncoderFactory(array(
            'OpenCastle\\SecurityBundle\\Entity\\Player' => array(
                'class' => 'Symfony\\Component\\Security\\Core\\Encoder\\MessageDigestPasswordEncoder',
                'arguments' => array('sha1', false),
            ),
        ));

        $player = new Player();
        $player->setUsername('testing');
        $player->setEmail('test@test.com');
        $player->setEmailValidationHash('verysecurehash');

        $entityManager = $this
            ->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        $eventDispatcherMock = $this
            ->getMockBuilder(EventDispatcherInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        
        /* @noinspection PhpParamsInspection */
        $playerManager = new PlayerManager($entityManager, $encoderFactory, $eventDispatcherMock);
        $return = $playerManager->validateEmail($player, 'verysecurebutdifferenthash');

        $this->assertFalse($return);
        $this->assertFalse($player->getEmailVerified());
    }

    public function testValidateEmailSuccess()
    {
        $encoderFactory = new EncoderFactory(array(
            'OpenCastle\\SecurityBundle\\Entity\\Player' => array(
                'class' => 'Symfony\\Component\\Security\\Core\\Encoder\\MessageDigestPasswordEncoder',
                'arguments' => array('sha1', false),
            ),
        ));

        $player = new Player();
        $player->setUsername('testing');
        $player->setEmail('test@test.com');
        $player->setEmailValidationHash('verysecurehash');

        $entityManager = $this
            ->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        $entityManager->expects($this->once())
            ->method('flush')
            ->will($this->returnValue(null));

        $eventDispatcherMock = $this
            ->getMockBuilder(EventDispatcherInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        /* @noinspection PhpParamsInspection */
        $playerManager = new PlayerManager($entityManager, $encoderFactory, $eventDispatcherMock);
        $return = $playerManager->validateEmail($player, 'verysecurehash');

        $this->assertTrue($return);
        $this->assertTrue($player->getEmailVerified());
    }
}
