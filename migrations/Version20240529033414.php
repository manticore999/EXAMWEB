<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240529033414 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX email ON personne');
        $this->addSql('DROP INDEX reset_token_hash ON personne');
        $this->addSql('ALTER TABLE personne CHANGE reset_token_hash reset_token_hash VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY reviews_ibfk_1');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY reviews_ibfk_2');
        $this->addSql('ALTER TABLE reviews ADD created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE restaurant_id restaurant_id INT DEFAULT NULL, CHANGE personne_id personne_id INT DEFAULT NULL, CHANGE rating rating INT DEFAULT NULL');
        $this->addSql('DROP INDEX restaurant_id ON reviews');
        $this->addSql('CREATE INDEX IDX_6970EB0FB1E7706E ON reviews (restaurant_id)');
        $this->addSql('DROP INDEX personne_id ON reviews');
        $this->addSql('CREATE INDEX IDX_6970EB0FA21BD112 ON reviews (personne_id)');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT reviews_ibfk_1 FOREIGN KEY (restaurant_id) REFERENCES restaurants (id)');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT reviews_ibfk_2 FOREIGN KEY (personne_id) REFERENCES personne (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personne CHANGE reset_token_hash reset_token_hash VARCHAR(64) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX email ON personne (email)');
        $this->addSql('CREATE UNIQUE INDEX reset_token_hash ON personne (reset_token_hash)');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0FB1E7706E');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0FA21BD112');
        $this->addSql('ALTER TABLE reviews DROP created_at, CHANGE restaurant_id restaurant_id INT NOT NULL, CHANGE personne_id personne_id INT NOT NULL, CHANGE rating rating INT NOT NULL');
        $this->addSql('DROP INDEX idx_6970eb0fa21bd112 ON reviews');
        $this->addSql('CREATE INDEX personne_id ON reviews (personne_id)');
        $this->addSql('DROP INDEX idx_6970eb0fb1e7706e ON reviews');
        $this->addSql('CREATE INDEX restaurant_id ON reviews (restaurant_id)');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0FB1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurants (id)');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0FA21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id)');
    }
}
