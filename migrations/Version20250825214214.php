<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250825214214 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE flights CHANGE city_departure city_departure INT NOT NULL, CHANGE city_arrival city_arrival INT NOT NULL, CHANGE price price NUMERIC(10, 2) NOT NULL');
        $this->addSql('ALTER TABLE flights ADD CONSTRAINT FK_FC74B5EAE1BDDA64 FOREIGN KEY (city_departure) REFERENCES cities (id)');
        $this->addSql('ALTER TABLE flights ADD CONSTRAINT FK_FC74B5EAE6ADE2E6 FOREIGN KEY (city_arrival) REFERENCES cities (id)');
        $this->addSql('CREATE INDEX IDX_FC74B5EAE1BDDA64 ON flights (city_departure)');
        $this->addSql('CREATE INDEX IDX_FC74B5EAE6ADE2E6 ON flights (city_arrival)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE flights DROP FOREIGN KEY FK_FC74B5EAE1BDDA64');
        $this->addSql('ALTER TABLE flights DROP FOREIGN KEY FK_FC74B5EAE6ADE2E6');
        $this->addSql('DROP INDEX IDX_FC74B5EAE1BDDA64 ON flights');
        $this->addSql('DROP INDEX IDX_FC74B5EAE6ADE2E6 ON flights');
        $this->addSql('ALTER TABLE flights CHANGE city_departure city_departure VARCHAR(255) NOT NULL, CHANGE city_arrival city_arrival VARCHAR(255) NOT NULL, CHANGE price price NUMERIC(10, 0) NOT NULL');
    }
}
