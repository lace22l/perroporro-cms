<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250912104830 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE blog_post (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, content CLOB NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , published_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , deleted_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , tags VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_BA5AE01DF675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_BA5AE01DF675F31B ON blog_post (author_id)');
        $this->addSql('CREATE TABLE "user" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME ON "user" (username)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE blog_post');
        $this->addSql('DROP TABLE "user"');
    }
}
