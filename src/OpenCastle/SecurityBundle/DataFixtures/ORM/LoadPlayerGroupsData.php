<?php
/**
 * Loads the default data for the PlayerGroups
 * in the database
 * Created by PhpStorm.
 * User: zack
 * Date: 16.11.15
 * Time: 22:18.
 */

namespace OpenCastle\SecurityBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OpenCastle\SecurityBundle\Entity\PlayerGroup;

/**
 * Class LoadPlayerGroupsData.
 */
class LoadPlayerGroupsData implements FixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        // load the "normal player" group
        $playerGroup = new PlayerGroup();
        $playerGroup->setName('Player');

        $manager->persist($playerGroup);
        $manager->flush();
    }
}
