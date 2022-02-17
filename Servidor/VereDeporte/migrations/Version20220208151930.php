<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220208151930 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE apunta_equipo');
        $this->addSql('DROP TABLE apunta_liga');
        $this->addSql('DROP TABLE solicita_equipo');
        $this->addSql('DROP TABLE solicita_usuario');
        $this->addSql('ALTER TABLE apunta ADD equipo_id INT DEFAULT NULL, ADD liga_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE apunta ADD CONSTRAINT FK_E4F6C62B23BFBED FOREIGN KEY (equipo_id) REFERENCES equipo (id)');
        $this->addSql('ALTER TABLE apunta ADD CONSTRAINT FK_E4F6C62BCF098064 FOREIGN KEY (liga_id) REFERENCES liga (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E4F6C62B23BFBED ON apunta (equipo_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E4F6C62BCF098064 ON apunta (liga_id)');
        $this->addSql('ALTER TABLE solicita ADD usuario_id INT DEFAULT NULL, ADD equipo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE solicita ADD CONSTRAINT FK_CE64EA75DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE solicita ADD CONSTRAINT FK_CE64EA7523BFBED FOREIGN KEY (equipo_id) REFERENCES equipo (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CE64EA75DB38439E ON solicita (usuario_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CE64EA7523BFBED ON solicita (equipo_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE apunta_equipo (apunta_id INT NOT NULL, equipo_id INT NOT NULL, INDEX IDX_A9CD57D523BFBED (equipo_id), INDEX IDX_A9CD57D59B274B34 (apunta_id), PRIMARY KEY(apunta_id, equipo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE apunta_liga (apunta_id INT NOT NULL, liga_id INT NOT NULL, INDEX IDX_34F22DF8CF098064 (liga_id), INDEX IDX_34F22DF89B274B34 (apunta_id), PRIMARY KEY(apunta_id, liga_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE solicita_equipo (solicita_id INT NOT NULL, equipo_id INT NOT NULL, INDEX IDX_CE003B5823BFBED (equipo_id), INDEX IDX_CE003B58DA35D162 (solicita_id), PRIMARY KEY(solicita_id, equipo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE solicita_usuario (solicita_id INT NOT NULL, usuario_id INT NOT NULL, INDEX IDX_D00D2C7BDB38439E (usuario_id), INDEX IDX_D00D2C7BDA35D162 (solicita_id), PRIMARY KEY(solicita_id, usuario_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE apunta_equipo ADD CONSTRAINT FK_A9CD57D523BFBED FOREIGN KEY (equipo_id) REFERENCES equipo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apunta_equipo ADD CONSTRAINT FK_A9CD57D59B274B34 FOREIGN KEY (apunta_id) REFERENCES apunta (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apunta_liga ADD CONSTRAINT FK_34F22DF8CF098064 FOREIGN KEY (liga_id) REFERENCES liga (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apunta_liga ADD CONSTRAINT FK_34F22DF89B274B34 FOREIGN KEY (apunta_id) REFERENCES apunta (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE solicita_equipo ADD CONSTRAINT FK_CE003B58DA35D162 FOREIGN KEY (solicita_id) REFERENCES solicita (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE solicita_equipo ADD CONSTRAINT FK_CE003B5823BFBED FOREIGN KEY (equipo_id) REFERENCES equipo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE solicita_usuario ADD CONSTRAINT FK_D00D2C7BDB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE solicita_usuario ADD CONSTRAINT FK_D00D2C7BDA35D162 FOREIGN KEY (solicita_id) REFERENCES solicita (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apunta DROP FOREIGN KEY FK_E4F6C62B23BFBED');
        $this->addSql('ALTER TABLE apunta DROP FOREIGN KEY FK_E4F6C62BCF098064');
        $this->addSql('DROP INDEX UNIQ_E4F6C62B23BFBED ON apunta');
        $this->addSql('DROP INDEX UNIQ_E4F6C62BCF098064 ON apunta');
        $this->addSql('ALTER TABLE apunta DROP equipo_id, DROP liga_id');
        $this->addSql('ALTER TABLE solicita DROP FOREIGN KEY FK_CE64EA75DB38439E');
        $this->addSql('ALTER TABLE solicita DROP FOREIGN KEY FK_CE64EA7523BFBED');
        $this->addSql('DROP INDEX UNIQ_CE64EA75DB38439E ON solicita');
        $this->addSql('DROP INDEX UNIQ_CE64EA7523BFBED ON solicita');
        $this->addSql('ALTER TABLE solicita DROP usuario_id, DROP equipo_id');
    }
}
