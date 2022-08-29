<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220829081326 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE campus ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE participant ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE sortie ADD description VARCHAR(255) DEFAULT NULL, ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE ville ADD slug VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE campus DROP slug');
        $this->addSql('ALTER TABLE participant DROP slug');
        $this->addSql('ALTER TABLE sortie DROP description, DROP slug');
        $this->addSql('ALTER TABLE ville DROP slug');
    }
}
