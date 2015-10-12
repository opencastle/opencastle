<?php
/**
 * Created by PhpStorm.
 * User: zack
 * Date: 11.10.15
 * Time: 12:51
 */

namespace OpenCastle\SecurityBundle\Tests\Security;


use OpenCastle\SecurityBundle\Entity\PlayerGroup;
use OpenCastle\SecurityBundle\Security\GroupManager;

class GroupManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateGroup()
    {

        $entityManager = $this
            ->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        $groupManager = new GroupManager($entityManager);

        $group = $groupManager->createGroup();

        $this->assertInstanceOf('\\OpenCastle\\SecurityBundle\\Entity\\PlayerGroup', $group);
        $this->assertInstanceOf('\\Symfony\\Component\\Security\\Core\\Role\\RoleInterface', $group);

    }

    public function testUpdateGroup()
    {
        $entityManager = $this
            ->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        $groupManager = new GroupManager($entityManager);

        $group = $groupManager->createGroup();

        $groupManager->updateGroup($group);
    }
}