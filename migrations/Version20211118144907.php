<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211118144907 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE url_entry (id INT AUTO_INCREMENT NOT NULL, original_url VARCHAR(255) NOT NULL, short_url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE url_events (id INT AUTO_INCREMENT NOT NULL, url_entry_id INT DEFAULT NULL, INDEX IDX_9D2317BAD85627CB (url_entry_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE url_events ADD CONSTRAINT FK_9D2317BAD85627CB FOREIGN KEY (url_entry_id) REFERENCES url_entry (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE url_events DROP FOREIGN KEY FK_9D2317BAD85627CB');
        $this->addSql('DROP TABLE url_entry');
        $this->addSql('DROP TABLE url_events');
    }
}
