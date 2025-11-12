<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251021162716 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE flights DROP FOREIGN KEY FK_FC74B5EAE1BDDA64');
        $this->addSql('ALTER TABLE flights DROP FOREIGN KEY FK_FC74B5EAE6ADE2E6');
        $this->addSql('DROP INDEX IDX_FC74B5EAE1BDDA64 ON flights');
        $this->addSql('DROP INDEX IDX_FC74B5EAE6ADE2E6 ON flights');
        $this->addSql('ALTER TABLE flights DROP city_departure, DROP city_arrival, CHANGE airport_departure airport_departure INT NOT NULL, CHANGE airport_arrival airport_arrival INT NOT NULL');
        $this->addSql('ALTER TABLE flights ADD CONSTRAINT FK_FC74B5EAD9D508BA FOREIGN KEY (airport_departure) REFERENCES airport (id)');
        $this->addSql('ALTER TABLE flights ADD CONSTRAINT FK_FC74B5EA262F629C FOREIGN KEY (airport_arrival) REFERENCES airport (id)');
        $this->addSql('CREATE INDEX IDX_FC74B5EAD9D508BA ON flights (airport_departure)');
        $this->addSql('CREATE INDEX IDX_FC74B5EA262F629C ON flights (airport_arrival)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE flights DROP FOREIGN KEY FK_FC74B5EAD9D508BA');
        $this->addSql('ALTER TABLE flights DROP FOREIGN KEY FK_FC74B5EA262F629C');
        $this->addSql('DROP INDEX IDX_FC74B5EAD9D508BA ON flights');
        $this->addSql('DROP INDEX IDX_FC74B5EA262F629C ON flights');
        $this->addSql('ALTER TABLE flights ADD city_departure INT NOT NULL, ADD city_arrival INT NOT NULL, CHANGE airport_departure airport_departure VARCHAR(255) NOT NULL, CHANGE airport_arrival airport_arrival VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE flights ADD CONSTRAINT FK_FC74B5EAE1BDDA64 FOREIGN KEY (city_departure) REFERENCES cities (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE flights ADD CONSTRAINT FK_FC74B5EAE6ADE2E6 FOREIGN KEY (city_arrival) REFERENCES cities (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_FC74B5EAE1BDDA64 ON flights (city_departure)');
        $this->addSql('CREATE INDEX IDX_FC74B5EAE6ADE2E6 ON flights (city_arrival)');
    }
}
