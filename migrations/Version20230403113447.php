<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230403113447 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE developer (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE game (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, developer_id INTEGER DEFAULT NULL, system_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, current_price NUMERIC(5, 2) NOT NULL, age_rating VARCHAR(8) DEFAULT NULL, box_art_uri VARCHAR(255) DEFAULT NULL, cex_id VARCHAR(255) NOT NULL, CONSTRAINT FK_232B318C64DD9267 FOREIGN KEY (developer_id) REFERENCES developer (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_232B318CD0952FA5 FOREIGN KEY (system_id) REFERENCES system (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_232B318C64DD9267 ON game (developer_id)');
        $this->addSql('CREATE INDEX IDX_232B318CD0952FA5 ON game (system_id)');
        $this->addSql('CREATE TABLE price_history (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, timestamp DATETIME NOT NULL, price NUMERIC(5, 2) NOT NULL)');
        $this->addSql('CREATE TABLE price_history_game (price_history_id INTEGER NOT NULL, game_id INTEGER NOT NULL, PRIMARY KEY(price_history_id, game_id), CONSTRAINT FK_DCCD2DEDAA8D8B56 FOREIGN KEY (price_history_id) REFERENCES price_history (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_DCCD2DEDE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_DCCD2DEDAA8D8B56 ON price_history_game (price_history_id)');
        $this->addSql('CREATE INDEX IDX_DCCD2DEDE48FD905 ON price_history_game (game_id)');
        $this->addSql('CREATE TABLE setting (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, value VARCHAR(255) DEFAULT NULL, description VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE system (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, cex_id INTEGER NOT NULL)');
        $this->addSql('INSERT INTO setting (name, description, value, type) VALUES ("darkMode", "Dark Mode", "1", "boolean")');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE developer');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE price_history');
        $this->addSql('DROP TABLE price_history_game');
        $this->addSql('DROP TABLE setting');
        $this->addSql('DROP TABLE system');
    }
}
