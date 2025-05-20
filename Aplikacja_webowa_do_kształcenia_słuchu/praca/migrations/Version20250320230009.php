<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250320230009 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE music_file ADD COLUMN updated_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__music_file AS SELECT id, file_name, format FROM music_file');
        $this->addSql('DROP TABLE music_file');
        $this->addSql('CREATE TABLE music_file (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, file_name VARCHAR(255) NOT NULL, format VARCHAR(10) NOT NULL)');
        $this->addSql('INSERT INTO music_file (id, file_name, format) SELECT id, file_name, format FROM __temp__music_file');
        $this->addSql('DROP TABLE __temp__music_file');
    }
}
