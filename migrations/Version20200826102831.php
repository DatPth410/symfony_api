<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200826102831 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movie DROP FOREIGN KEY FK_1D5EF26F28BE1523');
        $this->addSql('ALTER TABLE theater DROP FOREIGN KEY FK_46DD815428BE1523');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE showtime');
        $this->addSql('DROP TABLE theater');
        $this->addSql('DROP INDEX IDX_1D5EF26F28BE1523 ON movie');
        $this->addSql('ALTER TABLE movie CHANGE showtime_id slot INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE showtime (id INT AUTO_INCREMENT NOT NULL, slot INT NOT NULL, time DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE theater (id INT AUTO_INCREMENT NOT NULL, showtime_id INT DEFAULT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_46DD815428BE1523 (showtime_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE theater ADD CONSTRAINT FK_46DD815428BE1523 FOREIGN KEY (showtime_id) REFERENCES showtime (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE movie CHANGE slot showtime_id INT NOT NULL');
        $this->addSql('ALTER TABLE movie ADD CONSTRAINT FK_1D5EF26F28BE1523 FOREIGN KEY (showtime_id) REFERENCES showtime (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_1D5EF26F28BE1523 ON movie (showtime_id)');
    }
}
