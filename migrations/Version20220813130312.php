<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220813130312 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE developer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, developer_id INT DEFAULT NULL, system_id INT NOT NULL, name VARCHAR(255) NOT NULL, current_price NUMERIC(5, 2) NOT NULL, age_rating VARCHAR(8) DEFAULT NULL, box_art_uri VARCHAR(255) DEFAULT NULL, cex_id VARCHAR(255) NOT NULL, INDEX IDX_232B318C64DD9267 (developer_id), INDEX IDX_232B318CD0952FA5 (system_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE price_history (id INT AUTO_INCREMENT NOT NULL, timestamp DATETIME NOT NULL, price NUMERIC(5, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE price_history_game (price_history_id INT NOT NULL, game_id INT NOT NULL, INDEX IDX_DCCD2DEDAA8D8B56 (price_history_id), INDEX IDX_DCCD2DEDE48FD905 (game_id), PRIMARY KEY(price_history_id, game_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE system (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, cex_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C64DD9267 FOREIGN KEY (developer_id) REFERENCES developer (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CD0952FA5 FOREIGN KEY (system_id) REFERENCES system (id)');
        $this->addSql('ALTER TABLE price_history_game ADD CONSTRAINT FK_DCCD2DEDAA8D8B56 FOREIGN KEY (price_history_id) REFERENCES price_history (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE price_history_game ADD CONSTRAINT FK_DCCD2DEDE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C64DD9267');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CD0952FA5');
        $this->addSql('ALTER TABLE price_history_game DROP FOREIGN KEY FK_DCCD2DEDAA8D8B56');
        $this->addSql('ALTER TABLE price_history_game DROP FOREIGN KEY FK_DCCD2DEDE48FD905');
        $this->addSql('DROP TABLE developer');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE price_history');
        $this->addSql('DROP TABLE price_history_game');
        $this->addSql('DROP TABLE system');
    }
}
