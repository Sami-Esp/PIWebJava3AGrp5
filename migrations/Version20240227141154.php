<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240227141154 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE don ADD association_id INT NOT NULL');
        $this->addSql('ALTER TABLE don ADD CONSTRAINT FK_F8F081D9EFB9C8A5 FOREIGN KEY (association_id) REFERENCES association (id)');
        $this->addSql('CREATE INDEX IDX_F8F081D9EFB9C8A5 ON don (association_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE don DROP FOREIGN KEY FK_F8F081D9EFB9C8A5');
        $this->addSql('DROP INDEX IDX_F8F081D9EFB9C8A5 ON don');
        $this->addSql('ALTER TABLE don DROP association_id');
    }
}
