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
        $this->addSql('ALTER TABLE campus ADD slug VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE participant ADD slug VARCHAR(180) NOT NULL');
        $this->addSql('ALTER TABLE sortie ADD description VARCHAR(255) DEFAULT NULL, ADD slug VARCHAR(150) NOT NULL');
        $this->addSql('ALTER TABLE ville ADD slug VARCHAR(100) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_38C5106E989D9B62 ON campus (slug)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_38C5106E989D9B62 ON participant (slug)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_38C5106E989D9B62 ON sortie (slug)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_38C5106E989D9B62 ON ville (slug)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_38C5106E989D9B62 ON campus');
        $this->addSql('DROP INDEX UNIQ_38C5106E989D9B62 ON participant');
        $this->addSql('DROP INDEX UNIQ_38C5106E989D9B62 ON sortie');
        $this->addSql('DROP INDEX UNIQ_38C5106E989D9B62 ON ville');
        $this->addSql('ALTER TABLE campus DROP slug');
        $this->addSql('ALTER TABLE participant DROP slug');
        $this->addSql('ALTER TABLE sortie DROP description, DROP slug');
        $this->addSql('ALTER TABLE ville DROP slug');
    }
}
