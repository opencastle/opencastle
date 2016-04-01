<?php

namespace OpenCastle\DatabaseMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use OpenCastle\CoreBundle\Entity\Stat;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160315205214 extends AbstractMigration implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE player_stat (id INT AUTO_INCREMENT NOT NULL, player_id INT DEFAULT NULL, stat_id INT DEFAULT NULL, value INT NOT NULL, INDEX IDX_82A2AF1299E6F5DF (player_id), INDEX IDX_82A2AF129502F0B (stat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stat (id INT AUTO_INCREMENT NOT NULL, fullName VARCHAR(255) NOT NULL, shortName VARCHAR(10) NOT NULL, initialValue INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE player_stat ADD CONSTRAINT FK_82A2AF1299E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE player_stat ADD CONSTRAINT FK_82A2AF129502F0B FOREIGN KEY (stat_id) REFERENCES stat (id)');
    }

    public function postUp(Schema $schema)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');

        $statsToCreate = array(
            array('Santé', 'hp', 100),
            array('Soif', 'thirst', 80),
            array('Faim', 'hunger', 80)
        );

        foreach ($statsToCreate as $statToCreate) {
            $stat = new Stat();
            $stat
                ->setFullName($statToCreate[0])
                ->setShortName($statToCreate[1])
                ->setInitialValue($statToCreate[2])
            ;
            $em->persist($stat);
        }

        $em->flush();
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE player_stat DROP FOREIGN KEY FK_82A2AF129502F0B');
        $this->addSql('DROP TABLE player_stat');
        $this->addSql('DROP TABLE stat');
    }
}
