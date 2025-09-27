<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250927082128 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE app_setting (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO app_setting ( name, value) VALUES( "installed", "0")');
        $this->addSql('INSERT INTO app_setting ( name, value) VALUES( "background", "/assets/bg.gif")');
        $this->addSql('INSERT INTO app_setting ( name, value) VALUES( "title", "My personal blog")');
        $this->addSql('INSERT INTO app_setting ( name, value) VALUES( "blogEnabled", "1")');
        $this->addSql('INSERT INTO app_setting ( name, value) VALUES( "galleryEnabled", "1")');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE app_setting');
    }
}
