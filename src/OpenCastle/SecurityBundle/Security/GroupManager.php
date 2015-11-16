<?php
/**
 * Class managing creation and updates of a PlayerGroup entity
 *
 * User: zack
 * Date: 10.10.15
 * Time: 12:30
 */

namespace OpenCastle\SecurityBundle\Security;

use Doctrine\ORM\EntityManager;
use OpenCastle\SecurityBundle\Entity\PlayerGroup;

class GroupManager
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Creates a new, empty instance of PlayerGroup
     *
     * @return PlayerGroup
     */
    public function createGroup()
    {
        return new PlayerGroup();
    }

    /**
     * Returns the default group (standard player)
     *
     * @return PlayerGroup
     */
    public function getDefaultGroup()
    {
        return $this->entityManager->getRepository('OpenCastleSecurityBundle:PlayerGroup')->find(1);
    }

    /**
     * Updates a PlayerGroup and eventually flushes the DB
     *
     * @param PlayerGroup $group
     * @param bool|true $flush
     */
    public function updateGroup(PlayerGroup $group, $flush = true)
    {
        $this->entityManager->persist($group);

        if ($flush) {
            $this->entityManager->flush();
        }
    }

}