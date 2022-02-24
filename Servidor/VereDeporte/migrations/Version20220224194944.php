<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220224194944 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partido DROP INDEX UNIQ_4E79750B5D5A2101, ADD INDEX IDX_4E79750B5D5A2101 (local_id)');
        $this->addSql('ALTER TABLE partido DROP INDEX UNIQ_4E79750BD80AA8AF, ADD INDEX IDX_4E79750BD80AA8AF (visitante_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partido DROP INDEX IDX_4E79750B5D5A2101, ADD UNIQUE INDEX UNIQ_4E79750B5D5A2101 (local_id)');
        $this->addSql('ALTER TABLE partido DROP INDEX IDX_4E79750BD80AA8AF, ADD UNIQUE INDEX UNIQ_4E79750BD80AA8AF (visitante_id)');
    }
}
