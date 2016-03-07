<?php

namespace OpenCastle\DatabaseMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160307180737 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE player (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(40) NOT NULL, email VARCHAR(254) DEFAULT NULL, creation_date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player_player_groups (player_id INT NOT NULL, player_group_id INT NOT NULL, INDEX IDX_BA8DD31A99E6F5DF (player_id), INDEX IDX_BA8DD31AF88398A7 (player_group_id), PRIMARY KEY(player_id, player_group_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE player_player_groups ADD CONSTRAINT FK_BA8DD31A99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE player_player_groups ADD CONSTRAINT FK_BA8DD31AF88398A7 FOREIGN KEY (player_group_id) REFERENCES player_group (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE player_player_groups DROP FOREIGN KEY FK_BA8DD31A99E6F5DF');
        $this->addSql('ALTER TABLE player_player_groups DROP FOREIGN KEY FK_BA8DD31AF88398A7');
        $this->addSql('DROP TABLE player');
        $this->addSql('DROP TABLE player_player_groups');
        $this->addSql('DROP TABLE player_group');
    }
}
