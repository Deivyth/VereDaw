<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220224112527 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partido DROP INDEX UNIQ_4E79750BA17A385C, ADD INDEX IDX_4E79750BA17A385C (campo_id)');
        $this->addSql('ALTER TABLE partido CHANGE fecha fecha DATETIME DEFAULT NULL, CHANGE resultado resultado VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE reserva DROP INDEX UNIQ_188D2E3BA17A385C, ADD INDEX IDX_188D2E3BA17A385C (campo_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partido DROP INDEX IDX_4E79750BA17A385C, ADD UNIQUE INDEX UNIQ_4E79750BA17A385C (campo_id)');
        $this->addSql('ALTER TABLE partido CHANGE fecha fecha DATETIME NOT NULL, CHANGE resultado resultado VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE reserva DROP INDEX IDX_188D2E3BA17A385C, ADD UNIQUE INDEX UNIQ_188D2E3BA17A385C (campo_id)');
    }
}
