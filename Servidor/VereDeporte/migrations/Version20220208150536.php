<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220208150536 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE apunta (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE apunta_equipo (apunta_id INT NOT NULL, equipo_id INT NOT NULL, INDEX IDX_A9CD57D59B274B34 (apunta_id), INDEX IDX_A9CD57D523BFBED (equipo_id), PRIMARY KEY(apunta_id, equipo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE apunta_liga (apunta_id INT NOT NULL, liga_id INT NOT NULL, INDEX IDX_34F22DF89B274B34 (apunta_id), INDEX IDX_34F22DF8CF098064 (liga_id), PRIMARY KEY(apunta_id, liga_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE campo (id INT AUTO_INCREMENT NOT NULL, tipo VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipo (id INT AUTO_INCREMENT NOT NULL, capitan_id INT DEFAULT NULL, nombre VARCHAR(255) NOT NULL, photo LONGBLOB NOT NULL, UNIQUE INDEX UNIQ_C49C530B5624577C (capitan_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE liga (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, fecha_inicio DATE NOT NULL, fecha_fin DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partido (id INT AUTO_INCREMENT NOT NULL, id_local_id INT DEFAULT NULL, id_visitante_id INT DEFAULT NULL, id_usuario_id INT DEFAULT NULL, id_campo_id INT DEFAULT NULL, fecha DATE NOT NULL, resultado VARCHAR(255) NOT NULL, INDEX IDX_4E79750BD81CD94 (id_local_id), INDEX IDX_4E79750BFBCBDDDD (id_visitante_id), INDEX IDX_4E79750B7EB2C349 (id_usuario_id), UNIQUE INDEX UNIQ_4E79750BF1A1D4C9 (id_campo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reserva (id INT AUTO_INCREMENT NOT NULL, id_equipo_id INT DEFAULT NULL, id_usuario_id INT DEFAULT NULL, id_campo_id INT DEFAULT NULL, fecha DATE NOT NULL, INDEX IDX_188D2E3B820E47CA (id_equipo_id), INDEX IDX_188D2E3B7EB2C349 (id_usuario_id), UNIQUE INDEX UNIQ_188D2E3BF1A1D4C9 (id_campo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE solicita (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE solicita_usuario (solicita_id INT NOT NULL, usuario_id INT NOT NULL, INDEX IDX_D00D2C7BDA35D162 (solicita_id), INDEX IDX_D00D2C7BDB38439E (usuario_id), PRIMARY KEY(solicita_id, usuario_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE solicita_equipo (solicita_id INT NOT NULL, equipo_id INT NOT NULL, INDEX IDX_CE003B58DA35D162 (solicita_id), INDEX IDX_CE003B5823BFBED (equipo_id), PRIMARY KEY(solicita_id, equipo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nombre VARCHAR(255) NOT NULL, photo LONGBLOB DEFAULT NULL, UNIQUE INDEX UNIQ_2265B05DE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE apunta_equipo ADD CONSTRAINT FK_A9CD57D59B274B34 FOREIGN KEY (apunta_id) REFERENCES apunta (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apunta_equipo ADD CONSTRAINT FK_A9CD57D523BFBED FOREIGN KEY (equipo_id) REFERENCES equipo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apunta_liga ADD CONSTRAINT FK_34F22DF89B274B34 FOREIGN KEY (apunta_id) REFERENCES apunta (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apunta_liga ADD CONSTRAINT FK_34F22DF8CF098064 FOREIGN KEY (liga_id) REFERENCES liga (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipo ADD CONSTRAINT FK_C49C530B5624577C FOREIGN KEY (capitan_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE partido ADD CONSTRAINT FK_4E79750BD81CD94 FOREIGN KEY (id_local_id) REFERENCES equipo (id)');
        $this->addSql('ALTER TABLE partido ADD CONSTRAINT FK_4E79750BFBCBDDDD FOREIGN KEY (id_visitante_id) REFERENCES equipo (id)');
        $this->addSql('ALTER TABLE partido ADD CONSTRAINT FK_4E79750B7EB2C349 FOREIGN KEY (id_usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE partido ADD CONSTRAINT FK_4E79750BF1A1D4C9 FOREIGN KEY (id_campo_id) REFERENCES campo (id)');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3B820E47CA FOREIGN KEY (id_equipo_id) REFERENCES equipo (id)');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3B7EB2C349 FOREIGN KEY (id_usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3BF1A1D4C9 FOREIGN KEY (id_campo_id) REFERENCES campo (id)');
        $this->addSql('ALTER TABLE solicita_usuario ADD CONSTRAINT FK_D00D2C7BDA35D162 FOREIGN KEY (solicita_id) REFERENCES solicita (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE solicita_usuario ADD CONSTRAINT FK_D00D2C7BDB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE solicita_equipo ADD CONSTRAINT FK_CE003B58DA35D162 FOREIGN KEY (solicita_id) REFERENCES solicita (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE solicita_equipo ADD CONSTRAINT FK_CE003B5823BFBED FOREIGN KEY (equipo_id) REFERENCES equipo (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apunta_equipo DROP FOREIGN KEY FK_A9CD57D59B274B34');
        $this->addSql('ALTER TABLE apunta_liga DROP FOREIGN KEY FK_34F22DF89B274B34');
        $this->addSql('ALTER TABLE partido DROP FOREIGN KEY FK_4E79750BF1A1D4C9');
        $this->addSql('ALTER TABLE reserva DROP FOREIGN KEY FK_188D2E3BF1A1D4C9');
        $this->addSql('ALTER TABLE apunta_equipo DROP FOREIGN KEY FK_A9CD57D523BFBED');
        $this->addSql('ALTER TABLE partido DROP FOREIGN KEY FK_4E79750BD81CD94');
        $this->addSql('ALTER TABLE partido DROP FOREIGN KEY FK_4E79750BFBCBDDDD');
        $this->addSql('ALTER TABLE reserva DROP FOREIGN KEY FK_188D2E3B820E47CA');
        $this->addSql('ALTER TABLE solicita_equipo DROP FOREIGN KEY FK_CE003B5823BFBED');
        $this->addSql('ALTER TABLE apunta_liga DROP FOREIGN KEY FK_34F22DF8CF098064');
        $this->addSql('ALTER TABLE solicita_usuario DROP FOREIGN KEY FK_D00D2C7BDA35D162');
        $this->addSql('ALTER TABLE solicita_equipo DROP FOREIGN KEY FK_CE003B58DA35D162');
        $this->addSql('ALTER TABLE equipo DROP FOREIGN KEY FK_C49C530B5624577C');
        $this->addSql('ALTER TABLE partido DROP FOREIGN KEY FK_4E79750B7EB2C349');
        $this->addSql('ALTER TABLE reserva DROP FOREIGN KEY FK_188D2E3B7EB2C349');
        $this->addSql('ALTER TABLE solicita_usuario DROP FOREIGN KEY FK_D00D2C7BDB38439E');
        $this->addSql('DROP TABLE apunta');
        $this->addSql('DROP TABLE apunta_equipo');
        $this->addSql('DROP TABLE apunta_liga');
        $this->addSql('DROP TABLE campo');
        $this->addSql('DROP TABLE equipo');
        $this->addSql('DROP TABLE liga');
        $this->addSql('DROP TABLE partido');
        $this->addSql('DROP TABLE reserva');
        $this->addSql('DROP TABLE solicita');
        $this->addSql('DROP TABLE solicita_usuario');
        $this->addSql('DROP TABLE solicita_equipo');
        $this->addSql('DROP TABLE usuario');
    }
}
