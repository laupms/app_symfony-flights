<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251113132519 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE discount DROP FOREIGN KEY discount_ibfk_1');
        $this->addSql('DROP INDEX IDX_E1E0B40EEC141EF8 ON discount');
        $this->addSql('ALTER TABLE discount CHANGE airline airline_id INT NOT NULL');
        $this->addSql('ALTER TABLE discount ADD CONSTRAINT FK_E1E0B40E130D0C16 FOREIGN KEY (airline_id) REFERENCES airline (id)');
        $this->addSql('CREATE INDEX IDX_E1E0B40E130D0C16 ON discount (airline_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE discount DROP FOREIGN KEY FK_E1E0B40E130D0C16');
        $this->addSql('DROP INDEX IDX_E1E0B40E130D0C16 ON discount');
        $this->addSql('ALTER TABLE discount CHANGE airline_id airline INT NOT NULL');
        $this->addSql('ALTER TABLE discount ADD CONSTRAINT discount_ibfk_1 FOREIGN KEY (airline) REFERENCES airline (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_E1E0B40EEC141EF8 ON discount (airline)');
    }
}
