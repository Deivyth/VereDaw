<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220219083433 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE solicita');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE solicita (id INT AUTO_INCREMENT NOT NULL, usuario_id INT DEFAULT NULL, equipo_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_CE64EA75DB38439E (usuario_id), UNIQUE INDEX UNIQ_CE64EA7523BFBED (equipo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE solicita ADD CONSTRAINT FK_CE64EA7523BFBED FOREIGN KEY (equipo_id) REFERENCES equipo (id)');
        $this->addSql('ALTER TABLE solicita ADD CONSTRAINT FK_CE64EA75DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
    }
}
