<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240324134847 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        //$this->addSql('ALTER TABLE flights DROP FOREIGN KEY flights_ibfk_1');
        //$this->addSql('ALTER TABLE flights DROP FOREIGN KEY flights_ibfk_2');
        //$this->addSql('DROP INDEX city_arrival ON flights');
        //$this->addSql('DROP INDEX IDX_FC74B5EAE1BDDA64 ON flights');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE flights ADD CONSTRAINT flights_ibfk_1 FOREIGN KEY (city_departure) REFERENCES cities (id)');
        $this->addSql('ALTER TABLE flights ADD CONSTRAINT flights_ibfk_2 FOREIGN KEY (city_arrival) REFERENCES cities (id)');
        $this->addSql('CREATE INDEX city_departure ON flights (city_departure, city_arrival)');
        $this->addSql('CREATE INDEX city_arrival ON flights (city_arrival)');
        $this->addSql('CREATE INDEX IDX_FC74B5EAE1BDDA64 ON flights (city_departure)');
    }
}
