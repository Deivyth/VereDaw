<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220221135205 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE liga_equipo (liga_id INT NOT NULL, equipo_id INT NOT NULL, INDEX IDX_983BBD17CF098064 (liga_id), INDEX IDX_983BBD1723BFBED (equipo_id), PRIMARY KEY(liga_id, equipo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuario_equipo (usuario_id INT NOT NULL, equipo_id INT NOT NULL, INDEX IDX_3E8EB002DB38439E (usuario_id), INDEX IDX_3E8EB00223BFBED (equipo_id), PRIMARY KEY(usuario_id, equipo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE liga_equipo ADD CONSTRAINT FK_983BBD17CF098064 FOREIGN KEY (liga_id) REFERENCES liga (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE liga_equipo ADD CONSTRAINT FK_983BBD1723BFBED FOREIGN KEY (equipo_id) REFERENCES equipo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE usuario_equipo ADD CONSTRAINT FK_3E8EB002DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE usuario_equipo ADD CONSTRAINT FK_3E8EB00223BFBED FOREIGN KEY (equipo_id) REFERENCES equipo (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE apunta');
        $this->addSql('DROP TABLE solicita');
        $this->addSql('ALTER TABLE partido DROP FOREIGN KEY FK_4E79750BFBCBDDDD');
        $this->addSql('ALTER TABLE partido DROP FOREIGN KEY FK_4E79750B7EB2C349');
        $this->addSql('ALTER TABLE partido DROP FOREIGN KEY FK_4E79750BF1A1D4C9');
        $this->addSql('ALTER TABLE partido DROP FOREIGN KEY FK_4E79750BD81CD94');
        $this->addSql('DROP INDEX IDX_4E79750BFBCBDDDD ON partido');
        $this->addSql('DROP INDEX IDX_4E79750B7EB2C349 ON partido');
        $this->addSql('DROP INDEX UNIQ_4E79750BF1A1D4C9 ON partido');
        $this->addSql('DROP INDEX IDX_4E79750BD81CD94 ON partido');
        $this->addSql('ALTER TABLE partido ADD local_id INT DEFAULT NULL, ADD visitante_id INT DEFAULT NULL, ADD vigilante_id INT DEFAULT NULL, ADD campo_id INT DEFAULT NULL, ADD liga_id INT DEFAULT NULL, DROP id_local_id, DROP id_visitante_id, DROP id_usuario_id, DROP id_campo_id, CHANGE fecha fecha DATETIME NOT NULL');
        $this->addSql('ALTER TABLE partido ADD CONSTRAINT FK_4E79750B5D5A2101 FOREIGN KEY (local_id) REFERENCES equipo (id)');
        $this->addSql('ALTER TABLE partido ADD CONSTRAINT FK_4E79750BD80AA8AF FOREIGN KEY (visitante_id) REFERENCES equipo (id)');
        $this->addSql('ALTER TABLE partido ADD CONSTRAINT FK_4E79750B5911A3A3 FOREIGN KEY (vigilante_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE partido ADD CONSTRAINT FK_4E79750BA17A385C FOREIGN KEY (campo_id) REFERENCES campo (id)');
        $this->addSql('ALTER TABLE partido ADD CONSTRAINT FK_4E79750BCF098064 FOREIGN KEY (liga_id) REFERENCES liga (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4E79750B5D5A2101 ON partido (local_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4E79750BD80AA8AF ON partido (visitante_id)');
        $this->addSql('CREATE INDEX IDX_4E79750B5911A3A3 ON partido (vigilante_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4E79750BA17A385C ON partido (campo_id)');
        $this->addSql('CREATE INDEX IDX_4E79750BCF098064 ON partido (liga_id)');
        $this->addSql('ALTER TABLE reserva DROP FOREIGN KEY FK_188D2E3B7EB2C349');
        $this->addSql('ALTER TABLE reserva DROP FOREIGN KEY FK_188D2E3BF1A1D4C9');
        $this->addSql('ALTER TABLE reserva DROP FOREIGN KEY FK_188D2E3B820E47CA');
        $this->addSql('DROP INDEX IDX_188D2E3B820E47CA ON reserva');
        $this->addSql('DROP INDEX IDX_188D2E3B7EB2C349 ON reserva');
        $this->addSql('DROP INDEX UNIQ_188D2E3BF1A1D4C9 ON reserva');
        $this->addSql('ALTER TABLE reserva ADD equipo_id INT DEFAULT NULL, ADD vigilante_id INT DEFAULT NULL, ADD campo_id INT DEFAULT NULL, DROP id_equipo_id, DROP id_usuario_id, DROP id_campo_id, CHANGE fecha fecha DATETIME NOT NULL');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3B23BFBED FOREIGN KEY (equipo_id) REFERENCES equipo (id)');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3B5911A3A3 FOREIGN KEY (vigilante_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3BA17A385C FOREIGN KEY (campo_id) REFERENCES campo (id)');
        $this->addSql('CREATE INDEX IDX_188D2E3B23BFBED ON reserva (equipo_id)');
        $this->addSql('CREATE INDEX IDX_188D2E3B5911A3A3 ON reserva (vigilante_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_188D2E3BA17A385C ON reserva (campo_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE apunta (id INT AUTO_INCREMENT NOT NULL, equipo_id INT DEFAULT NULL, liga_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_E4F6C62BCF098064 (liga_id), UNIQUE INDEX UNIQ_E4F6C62B23BFBED (equipo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE solicita (id INT AUTO_INCREMENT NOT NULL, usuario_id INT DEFAULT NULL, equipo_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_CE64EA75DB38439E (usuario_id), UNIQUE INDEX UNIQ_CE64EA7523BFBED (equipo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE apunta ADD CONSTRAINT FK_E4F6C62BCF098064 FOREIGN KEY (liga_id) REFERENCES liga (id)');
        $this->addSql('ALTER TABLE apunta ADD CONSTRAINT FK_E4F6C62B23BFBED FOREIGN KEY (equipo_id) REFERENCES equipo (id)');
        $this->addSql('ALTER TABLE solicita ADD CONSTRAINT FK_CE64EA75DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE solicita ADD CONSTRAINT FK_CE64EA7523BFBED FOREIGN KEY (equipo_id) REFERENCES equipo (id)');
        $this->addSql('DROP TABLE liga_equipo');
        $this->addSql('DROP TABLE usuario_equipo');
        $this->addSql('ALTER TABLE partido DROP FOREIGN KEY FK_4E79750B5D5A2101');
        $this->addSql('ALTER TABLE partido DROP FOREIGN KEY FK_4E79750BD80AA8AF');
        $this->addSql('ALTER TABLE partido DROP FOREIGN KEY FK_4E79750B5911A3A3');
        $this->addSql('ALTER TABLE partido DROP FOREIGN KEY FK_4E79750BA17A385C');
        $this->addSql('ALTER TABLE partido DROP FOREIGN KEY FK_4E79750BCF098064');
        $this->addSql('DROP INDEX UNIQ_4E79750B5D5A2101 ON partido');
        $this->addSql('DROP INDEX UNIQ_4E79750BD80AA8AF ON partido');
        $this->addSql('DROP INDEX IDX_4E79750B5911A3A3 ON partido');
        $this->addSql('DROP INDEX UNIQ_4E79750BA17A385C ON partido');
        $this->addSql('DROP INDEX IDX_4E79750BCF098064 ON partido');
        $this->addSql('ALTER TABLE partido ADD id_local_id INT DEFAULT NULL, ADD id_visitante_id INT DEFAULT NULL, ADD id_usuario_id INT DEFAULT NULL, ADD id_campo_id INT DEFAULT NULL, DROP local_id, DROP visitante_id, DROP vigilante_id, DROP campo_id, DROP liga_id, CHANGE fecha fecha DATE NOT NULL');
        $this->addSql('ALTER TABLE partido ADD CONSTRAINT FK_4E79750BFBCBDDDD FOREIGN KEY (id_visitante_id) REFERENCES equipo (id)');
        $this->addSql('ALTER TABLE partido ADD CONSTRAINT FK_4E79750B7EB2C349 FOREIGN KEY (id_usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE partido ADD CONSTRAINT FK_4E79750BF1A1D4C9 FOREIGN KEY (id_campo_id) REFERENCES campo (id)');
        $this->addSql('ALTER TABLE partido ADD CONSTRAINT FK_4E79750BD81CD94 FOREIGN KEY (id_local_id) REFERENCES equipo (id)');
        $this->addSql('CREATE INDEX IDX_4E79750BFBCBDDDD ON partido (id_visitante_id)');
        $this->addSql('CREATE INDEX IDX_4E79750B7EB2C349 ON partido (id_usuario_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4E79750BF1A1D4C9 ON partido (id_campo_id)');
        $this->addSql('CREATE INDEX IDX_4E79750BD81CD94 ON partido (id_local_id)');
        $this->addSql('ALTER TABLE reserva DROP FOREIGN KEY FK_188D2E3B23BFBED');
        $this->addSql('ALTER TABLE reserva DROP FOREIGN KEY FK_188D2E3B5911A3A3');
        $this->addSql('ALTER TABLE reserva DROP FOREIGN KEY FK_188D2E3BA17A385C');
        $this->addSql('DROP INDEX IDX_188D2E3B23BFBED ON reserva');
        $this->addSql('DROP INDEX IDX_188D2E3B5911A3A3 ON reserva');
        $this->addSql('DROP INDEX UNIQ_188D2E3BA17A385C ON reserva');
        $this->addSql('ALTER TABLE reserva ADD id_equipo_id INT DEFAULT NULL, ADD id_usuario_id INT DEFAULT NULL, ADD id_campo_id INT DEFAULT NULL, DROP equipo_id, DROP vigilante_id, DROP campo_id, CHANGE fecha fecha DATE NOT NULL');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3B7EB2C349 FOREIGN KEY (id_usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3BF1A1D4C9 FOREIGN KEY (id_campo_id) REFERENCES campo (id)');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3B820E47CA FOREIGN KEY (id_equipo_id) REFERENCES equipo (id)');
        $this->addSql('CREATE INDEX IDX_188D2E3B820E47CA ON reserva (id_equipo_id)');
        $this->addSql('CREATE INDEX IDX_188D2E3B7EB2C349 ON reserva (id_usuario_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_188D2E3BF1A1D4C9 ON reserva (id_campo_id)');
    }
}
