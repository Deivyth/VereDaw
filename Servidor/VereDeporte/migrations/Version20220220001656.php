<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220220001656 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE partido (id INT AUTO_INCREMENT NOT NULL, local_id INT DEFAULT NULL, visitante_id INT DEFAULT NULL, vigilante_id INT DEFAULT NULL, campo_id INT DEFAULT NULL, fecha DATETIME NOT NULL, resultado VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_4E79750B5D5A2101 (local_id), UNIQUE INDEX UNIQ_4E79750BD80AA8AF (visitante_id), INDEX IDX_4E79750B5911A3A3 (vigilante_id), UNIQUE INDEX UNIQ_4E79750BA17A385C (campo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reserva (id INT AUTO_INCREMENT NOT NULL, equipo_id INT DEFAULT NULL, vigilante_id INT DEFAULT NULL, campo_id INT DEFAULT NULL, fecha DATETIME NOT NULL, INDEX IDX_188D2E3B23BFBED (equipo_id), INDEX IDX_188D2E3B5911A3A3 (vigilante_id), UNIQUE INDEX UNIQ_188D2E3BA17A385C (campo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE partido ADD CONSTRAINT FK_4E79750B5D5A2101 FOREIGN KEY (local_id) REFERENCES equipo (id)');
        $this->addSql('ALTER TABLE partido ADD CONSTRAINT FK_4E79750BD80AA8AF FOREIGN KEY (visitante_id) REFERENCES equipo (id)');
        $this->addSql('ALTER TABLE partido ADD CONSTRAINT FK_4E79750B5911A3A3 FOREIGN KEY (vigilante_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE partido ADD CONSTRAINT FK_4E79750BA17A385C FOREIGN KEY (campo_id) REFERENCES campo (id)');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3B23BFBED FOREIGN KEY (equipo_id) REFERENCES equipo (id)');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3B5911A3A3 FOREIGN KEY (vigilante_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3BA17A385C FOREIGN KEY (campo_id) REFERENCES campo (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE partido');
        $this->addSql('DROP TABLE reserva');
    }
}
