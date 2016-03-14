<?php
/**
 * Groupmanager unit test class.
 *
 * User: zack
 * Date: 11.10.15
 * Time: 12:51
 */

namespace OpenCastle\SecurityBundle\Tests\Security;

use OpenCastle\SecurityBundle\Security\GroupManager;
use Symfony\Bridge\Doctrine\ManagerRegistry;

/**
 * Class GroupManagerTest.
 */
class GroupManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateGroup()
    {
        $managerRegistryMock = $this
            ->getMockBuilder(ManagerRegistry::class)
            ->disableOriginalConstructor()
            ->getMock();

        $entityManager = $this
            ->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        $managerRegistryMock->expects($this->once())
            ->method('getManager')
            ->will($this->returnValue($entityManager));

        /* @noinspection PhpParamsInspection */
        $groupManager = new GroupManager($managerRegistryMock);

        $group = $groupManager->createGroup();

        $this->assertInstanceOf('\\OpenCastle\\SecurityBundle\\Entity\\PlayerGroup', $group);
        $this->assertInstanceOf('\\Symfony\\Component\\Security\\Core\\Role\\RoleInterface', $group);
    }

    public function testUpdateGroup()
    {
        $managerRegistryMock = $this
            ->getMockBuilder(ManagerRegistry::class)
            ->disableOriginalConstructor()
            ->getMock();

        $entityManager = $this
            ->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        $managerRegistryMock->expects($this->once())
            ->method('getManager')
            ->will($this->returnValue($entityManager));

        /* @noinspection PhpParamsInspection */
        $groupManager = new GroupManager($managerRegistryMock);

        $group = $groupManager->createGroup();

        $groupManager->updateGroup($group);
    }
}
