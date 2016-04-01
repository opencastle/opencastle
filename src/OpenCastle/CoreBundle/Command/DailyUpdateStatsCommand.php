<?php

namespace OpenCastle\CoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class DailyUpdateStatsCommand.
 *
 * @codeCoverageIgnore
 */
class DailyUpdateStatsCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('opencastle:stats:daily-update')
            ->setDescription('Has to be run daily: Updates each player stats');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $statsHandler = $this->getContainer()->get('opencastle_core.stat_handler.chain');
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $players = $em->getRepository('OpenCastleSecurityBundle:Player')->findBy(array(
            'dead' => false,
        ));

        foreach ($players as $player) {
            $statsHandler->dailyUpdate($player);

            $now = new \DateTime();

            $player->setAge(16 + $player->getCreationDate()->diff($now, true)->d / 3);
        }

        $em->flush();
    }
}
