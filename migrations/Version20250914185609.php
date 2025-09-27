<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250914185609 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artwork ADD COLUMN is_nsfw BOOLEAN DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__artwork AS SELECT id, name, description, artist_name, artist_url, image_url FROM artwork');
        $this->addSql('DROP TABLE artwork');
        $this->addSql('CREATE TABLE artwork (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description CLOB NOT NULL, artist_name VARCHAR(255) DEFAULT NULL, artist_url VARCHAR(512) DEFAULT NULL, image_url CLOB DEFAULT NULL)');
        $this->addSql('INSERT INTO artwork (id, name, description, artist_name, artist_url, image_url) SELECT id, name, description, artist_name, artist_url, image_url FROM __temp__artwork');
        $this->addSql('DROP TABLE __temp__artwork');
    }
}
