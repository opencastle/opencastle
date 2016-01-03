<?php

namespace OpenCastle\SecurityBundle\Features\Context;

use OpenCastle\CoreBundle\Behat\BaseFeatureContext;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends BaseFeatureContext
{

    /**
     * Create a user
     *
     * @Given /^I have a user named "(.*)" with the password "(.*)"$/
     */
    public function createUser($username, $password)
    {
        $manager = $this->getContainer()->get('opencastle_security.player_manager');
        $player = $manager->createPlayer();
        $player
            ->setUsername($username)
            ->setEmail('test@test.com')
            ->setPlainPassword($password);


        $groupManager = $this->getContainer()->get('opencastle_security.group_manager');
        $player->addGroup($groupManager->getDefaultGroup());

        $manager->updatePlayer($player);
    }
}
