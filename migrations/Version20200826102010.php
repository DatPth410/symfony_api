<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200826102010 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_showtime (order_id INT NOT NULL, showtime_id INT NOT NULL, INDEX IDX_E2DC6F208D9F6D38 (order_id), INDEX IDX_E2DC6F2028BE1523 (showtime_id), PRIMARY KEY(order_id, showtime_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE showtime (id INT AUTO_INCREMENT NOT NULL, slot INT NOT NULL, time DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE showtime_movie (showtime_id INT NOT NULL, movie_id INT NOT NULL, INDEX IDX_253C290628BE1523 (showtime_id), INDEX IDX_253C29068F93B6FC (movie_id), PRIMARY KEY(showtime_id, movie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE showtime_theater (showtime_id INT NOT NULL, theater_id INT NOT NULL, INDEX IDX_E3E3628428BE1523 (showtime_id), INDEX IDX_E3E36284D70E4479 (theater_id), PRIMARY KEY(showtime_id, theater_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theater (id INT AUTO_INCREMENT NOT NULL, showtime_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_46DD815428BE1523 (showtime_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_showtime ADD CONSTRAINT FK_E2DC6F208D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_showtime ADD CONSTRAINT FK_E2DC6F2028BE1523 FOREIGN KEY (showtime_id) REFERENCES showtime (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE showtime_movie ADD CONSTRAINT FK_253C290628BE1523 FOREIGN KEY (showtime_id) REFERENCES showtime (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE showtime_movie ADD CONSTRAINT FK_253C29068F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE showtime_theater ADD CONSTRAINT FK_E3E3628428BE1523 FOREIGN KEY (showtime_id) REFERENCES showtime (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE showtime_theater ADD CONSTRAINT FK_E3E36284D70E4479 FOREIGN KEY (theater_id) REFERENCES theater (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE theater ADD CONSTRAINT FK_46DD815428BE1523 FOREIGN KEY (showtime_id) REFERENCES showtime (id)');
        $this->addSql('ALTER TABLE movie ADD showtime_id INT NOT NULL');
        $this->addSql('ALTER TABLE movie ADD CONSTRAINT FK_1D5EF26F28BE1523 FOREIGN KEY (showtime_id) REFERENCES showtime (id)');
        $this->addSql('CREATE INDEX IDX_1D5EF26F28BE1523 ON movie (showtime_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_showtime DROP FOREIGN KEY FK_E2DC6F208D9F6D38');
        $this->addSql('ALTER TABLE movie DROP FOREIGN KEY FK_1D5EF26F28BE1523');
        $this->addSql('ALTER TABLE order_showtime DROP FOREIGN KEY FK_E2DC6F2028BE1523');
        $this->addSql('ALTER TABLE showtime_movie DROP FOREIGN KEY FK_253C290628BE1523');
        $this->addSql('ALTER TABLE showtime_theater DROP FOREIGN KEY FK_E3E3628428BE1523');
        $this->addSql('ALTER TABLE theater DROP FOREIGN KEY FK_46DD815428BE1523');
        $this->addSql('ALTER TABLE showtime_theater DROP FOREIGN KEY FK_E3E36284D70E4479');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_showtime');
        $this->addSql('DROP TABLE showtime');
        $this->addSql('DROP TABLE showtime_movie');
        $this->addSql('DROP TABLE showtime_theater');
        $this->addSql('DROP TABLE theater');
        $this->addSql('DROP INDEX IDX_1D5EF26F28BE1523 ON movie');
        $this->addSql('ALTER TABLE movie DROP showtime_id');
    }
}
