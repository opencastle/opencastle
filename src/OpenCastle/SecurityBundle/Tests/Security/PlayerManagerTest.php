<?php
/**
 * PlayerManager unit test class
 *
 * User: zack
 * Date: 11.10.15
 * Time: 12:51
 */

namespace OpenCastle\SecurityBundle\Tests\Security;

use OpenCastle\SecurityBundle\Entity\Player;
use OpenCastle\SecurityBundle\Security\PlayerManager;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;

class PlayerManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testCreatePlayer()
    {
        $encoderFactory = new EncoderFactory(array(
            "opencastle_test" => array(
                "class" => "OpenCastle\\SecurityBundle\\Entity\\Player",
                "arguments" => array("sha1")
            )
        ));

        $entityManager = $this
            ->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        $playerManager = new PlayerManager($entityManager, $encoderFactory);

        $player = $playerManager->createPlayer();

        $this->assertInstanceOf('\\OpenCastle\\SecurityBundle\\Entity\\Player', $player);
        $this->assertNotEmpty($player->getSalt());

    }

    public function testUpdatePlayer()
    {
        $encoderFactory = new EncoderFactory(array(
            "OpenCastle\\SecurityBundle\\Entity\\Player" => array(
                "class" => "Symfony\\Component\\Security\\Core\\Encoder\\MessageDigestPasswordEncoder",
                "arguments" => array("sha1", false)
            )
        ));

        $entityManager = $this
            ->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        $playerManager = new PlayerManager($entityManager, $encoderFactory);

        $player = $playerManager->createPlayer();
        $player->setPlainPassword("test");

        $expectedPassword = $encoderFactory->getEncoder($player)->encodePassword("test", $player->getSalt());

        $playerManager->updatePlayer($player);

        $this->assertNotNull($player->getPassword());
        $this->assertEquals($expectedPassword, $player->getPassword());
        $this->assertNull($player->getPlainPassword());
    }

    public function testGetPlayerByUsername()
    {
        $encoderFactory = new EncoderFactory(array(
            "OpenCastle\\SecurityBundle\\Entity\\Player" => array(
                "class" => "Symfony\\Component\\Security\\Core\\Encoder\\MessageDigestPasswordEncoder",
                "arguments" => array("sha1", false)
            )
        ));

        $player = new Player();
        $player->setSalt(sha1(strval(mt_rand())));
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

        $playerManager = new PlayerManager($entityManager, $encoderFactory);

        $returnedPlayer = $playerManager->getPlayerByUsername('testing');

        $this->assertSame($player, $returnedPlayer);
    }

    public function testLoadUserByUsername()
    {
        $encoderFactory = new EncoderFactory(array(
            "OpenCastle\\SecurityBundle\\Entity\\Player" => array(
                "class" => "Symfony\\Component\\Security\\Core\\Encoder\\MessageDigestPasswordEncoder",
                "arguments" => array("sha1", false)
            )
        ));

        $player = new Player();
        $player->setSalt(sha1(strval(mt_rand())));
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

        $playerManager = new PlayerManager($entityManager, $encoderFactory);

        $returnedPlayer = $playerManager->loadUserByUsername($player->getUsername());

        $this->assertSame($player, $returnedPlayer);
    }

    /**
     * @expectedException \Symfony\Component\Security\Core\Exception\UsernameNotFoundException
     */
    public function testLoadUserByUsernameNonExistent()
    {
        $encoderFactory = new EncoderFactory(array(
            "OpenCastle\\SecurityBundle\\Entity\\Player" => array(
                "class" => "Symfony\\Component\\Security\\Core\\Encoder\\MessageDigestPasswordEncoder",
                "arguments" => array("sha1", false)
            )
        ));

        $player = new Player();
        $player->setSalt(sha1(strval(mt_rand())));
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

        $playerManager = new PlayerManager($entityManager, $encoderFactory);

        $playerManager->loadUserByUsername($player->getUsername());
    }

    public function testRefreshUser()
    {
        $encoderFactory = new EncoderFactory(array(
            "OpenCastle\\SecurityBundle\\Entity\\Player" => array(
                "class" => "Symfony\\Component\\Security\\Core\\Encoder\\MessageDigestPasswordEncoder",
                "arguments" => array("sha1", false)
            )
        ));

        $player = new Player();
        $player->setSalt(sha1(strval(mt_rand())));
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

        $playerManager = new PlayerManager($entityManager, $encoderFactory);

        $returnedPlayer = $playerManager->refreshUser($player);

        $this->assertSame($player, $returnedPlayer);
    }

    /**
     * @expectedException \Symfony\Component\Security\Core\Exception\UsernameNotFoundException
     */
    public function testRefreshUserWrongUserNonExistent()
    {
        $encoderFactory = new EncoderFactory(array(
            "OpenCastle\\SecurityBundle\\Entity\\Player" => array(
                "class" => "Symfony\\Component\\Security\\Core\\Encoder\\MessageDigestPasswordEncoder",
                "arguments" => array("sha1", false)
            )
        ));

        $player = new Player();
        $player->setSalt(sha1(strval(mt_rand())));
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

        $playerManager = new PlayerManager($entityManager, $encoderFactory);

        $playerManager->refreshUser($player);
    }

    public function testSupportsClass()
    {
        $encoderFactory = new EncoderFactory(array(
            "OpenCastle\\SecurityBundle\\Entity\\Player" => array(
                "class" => "Symfony\\Component\\Security\\Core\\Encoder\\MessageDigestPasswordEncoder",
                "arguments" => array("sha1", false)
            )
        ));

        $player = new Player();
        $player->setSalt(sha1(strval(mt_rand())));
        $player->setUsername('testing');

        $entityManager = $this
            ->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        $playerManager = new PlayerManager($entityManager, $encoderFactory);

        $this->assertTrue($playerManager->supportsClass(get_class($player)));
    }

    public function testSupportsClassWrongClass()
    {
        $encoderFactory = new EncoderFactory(array(
            "OpenCastle\\SecurityBundle\\Entity\\Player" => array(
                "class" => "Symfony\\Component\\Security\\Core\\Encoder\\MessageDigestPasswordEncoder",
                "arguments" => array("sha1", false)
            )
        ));

        $player = new Player();
        $player->setSalt(sha1(strval(mt_rand())));
        $player->setUsername('testing');

        $entityManager = $this
            ->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        $playerManager = new PlayerManager($entityManager, $encoderFactory);

        $this->assertFalse($playerManager->supportsClass("DummyFalseClass"));
    }
}