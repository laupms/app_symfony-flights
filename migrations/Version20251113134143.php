<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251113134143 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE flights DROP FOREIGN KEY flights_ibfk_1');
        $this->addSql('DROP INDEX IDX_FC74B5EAEC141EF8 ON flights');
        $this->addSql('ALTER TABLE flights CHANGE airline airline_id INT NOT NULL');
        $this->addSql('ALTER TABLE flights ADD CONSTRAINT FK_FC74B5EA130D0C16 FOREIGN KEY (airline_id) REFERENCES airline (id)');
        $this->addSql('CREATE INDEX IDX_FC74B5EA130D0C16 ON flights (airline_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE flights DROP FOREIGN KEY FK_FC74B5EA130D0C16');
        $this->addSql('DROP INDEX IDX_FC74B5EA130D0C16 ON flights');
        $this->addSql('ALTER TABLE flights CHANGE airline_id airline INT NOT NULL');
        $this->addSql('ALTER TABLE flights ADD CONSTRAINT flights_ibfk_1 FOREIGN KEY (airline) REFERENCES airline (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_FC74B5EAEC141EF8 ON flights (airline)');
    }
}
