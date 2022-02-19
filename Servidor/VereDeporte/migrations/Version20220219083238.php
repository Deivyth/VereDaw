<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220219083238 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE usuario_equipo (usuario_id INT NOT NULL, equipo_id INT NOT NULL, INDEX IDX_3E8EB002DB38439E (usuario_id), INDEX IDX_3E8EB00223BFBED (equipo_id), PRIMARY KEY(usuario_id, equipo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE usuario_equipo ADD CONSTRAINT FK_3E8EB002DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE usuario_equipo ADD CONSTRAINT FK_3E8EB00223BFBED FOREIGN KEY (equipo_id) REFERENCES equipo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipo DROP FOREIGN KEY FK_C49C530BDB38439E');
        $this->addSql('DROP INDEX IDX_C49C530BDB38439E ON equipo');
        $this->addSql('ALTER TABLE equipo DROP usuario_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE usuario_equipo');
        $this->addSql('ALTER TABLE equipo ADD usuario_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE equipo ADD CONSTRAINT FK_C49C530BDB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('CREATE INDEX IDX_C49C530BDB38439E ON equipo (usuario_id)');
    }
}
