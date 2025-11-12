<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251021143721 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE airport RENAME INDEX city_id TO IDX_7E91F7C28BAC62AF');
        $this->addSql('ALTER TABLE flights ADD airport_departure VARCHAR(255) NOT NULL, ADD airport_arrival VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE flights DROP airport_departure, DROP airport_arrival');
        $this->addSql('ALTER TABLE airport RENAME INDEX idx_7e91f7c28bac62af TO city_id');
    }
}
