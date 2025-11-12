<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251106175330 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tags (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tags_flights (tags_id INT NOT NULL, flights_id INT NOT NULL, INDEX IDX_DAC85EFB8D7B4FB4 (tags_id), INDEX IDX_DAC85EFBCEE7F62 (flights_id), PRIMARY KEY(tags_id, flights_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tags_flights ADD CONSTRAINT FK_DAC85EFB8D7B4FB4 FOREIGN KEY (tags_id) REFERENCES tags (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tags_flights ADD CONSTRAINT FK_DAC85EFBCEE7F62 FOREIGN KEY (flights_id) REFERENCES flights (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tags_flights DROP FOREIGN KEY FK_DAC85EFB8D7B4FB4');
        $this->addSql('ALTER TABLE tags_flights DROP FOREIGN KEY FK_DAC85EFBCEE7F62');
        $this->addSql('DROP TABLE tags');
        $this->addSql('DROP TABLE tags_flights');
    }
}
