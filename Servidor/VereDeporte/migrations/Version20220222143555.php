<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220222143555 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reserva (id INT AUTO_INCREMENT NOT NULL, equipo_id INT DEFAULT NULL, vigilante_id INT DEFAULT NULL, campo_id INT DEFAULT NULL, fecha DATETIME NOT NULL, INDEX IDX_188D2E3B23BFBED (equipo_id), INDEX IDX_188D2E3B5911A3A3 (vigilante_id), INDEX IDX_188D2E3BA17A385C (campo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3B23BFBED FOREIGN KEY (equipo_id) REFERENCES equipo (id)');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3B5911A3A3 FOREIGN KEY (vigilante_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3BA17A385C FOREIGN KEY (campo_id) REFERENCES campo (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE reserva');
    }
}
