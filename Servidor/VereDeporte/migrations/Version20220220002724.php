<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220220002724 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE liga_equipo (liga_id INT NOT NULL, equipo_id INT NOT NULL, INDEX IDX_983BBD17CF098064 (liga_id), INDEX IDX_983BBD1723BFBED (equipo_id), PRIMARY KEY(liga_id, equipo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE liga_equipo ADD CONSTRAINT FK_983BBD17CF098064 FOREIGN KEY (liga_id) REFERENCES liga (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE liga_equipo ADD CONSTRAINT FK_983BBD1723BFBED FOREIGN KEY (equipo_id) REFERENCES equipo (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE partido_equipo');
        $this->addSql('ALTER TABLE partido ADD liga_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE partido ADD CONSTRAINT FK_4E79750BCF098064 FOREIGN KEY (liga_id) REFERENCES liga (id)');
        $this->addSql('CREATE INDEX IDX_4E79750BCF098064 ON partido (liga_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE partido_equipo (partido_id INT NOT NULL, equipo_id INT NOT NULL, INDEX IDX_EB4ED1B023BFBED (equipo_id), INDEX IDX_EB4ED1B011856EB4 (partido_id), PRIMARY KEY(partido_id, equipo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE partido_equipo ADD CONSTRAINT FK_EB4ED1B023BFBED FOREIGN KEY (equipo_id) REFERENCES equipo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE partido_equipo ADD CONSTRAINT FK_EB4ED1B011856EB4 FOREIGN KEY (partido_id) REFERENCES partido (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE liga_equipo');
        $this->addSql('ALTER TABLE partido DROP FOREIGN KEY FK_4E79750BCF098064');
        $this->addSql('DROP INDEX IDX_4E79750BCF098064 ON partido');
        $this->addSql('ALTER TABLE partido DROP liga_id');
    }
}
