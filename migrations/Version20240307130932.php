<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240307130932 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE evenements (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(30) NOT NULL, date DATE NOT NULL, lieu VARCHAR(255) NOT NULL, description VARCHAR(500) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participants (id INT AUTO_INCREMENT NOT NULL, evenementp_id INT NOT NULL, nom VARCHAR(30) NOT NULL, prenom VARCHAR(30) NOT NULL, email VARCHAR(100) NOT NULL, telephone INT NOT NULL, INDEX IDX_716970927175833A (evenementp_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse (id INT AUTO_INCREMENT NOT NULL, id_reclamation_id INT NOT NULL, contenu VARCHAR(255) NOT NULL, date DATE NOT NULL, UNIQUE INDEX UNIQ_5FB6DEC7100D1FDF (id_reclamation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sponsors (id INT AUTO_INCREMENT NOT NULL, evenementd_id INT NOT NULL, nom VARCHAR(30) NOT NULL, montant DOUBLE PRECISION NOT NULL, INDEX IDX_9A31550FAE0E43F2 (evenementd_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, mdp VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, telephone INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE participants ADD CONSTRAINT FK_716970927175833A FOREIGN KEY (evenementp_id) REFERENCES evenements (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC7100D1FDF FOREIGN KEY (id_reclamation_id) REFERENCES reclamation (id)');
        $this->addSql('ALTER TABLE sponsors ADD CONSTRAINT FK_9A31550FAE0E43F2 FOREIGN KEY (evenementd_id) REFERENCES evenements (id)');
        $this->addSql('ALTER TABLE association CHANGE photo photo VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE reclamation ADD date_en_jour DATE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participants DROP FOREIGN KEY FK_716970927175833A');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC7100D1FDF');
        $this->addSql('ALTER TABLE sponsors DROP FOREIGN KEY FK_9A31550FAE0E43F2');
        $this->addSql('DROP TABLE evenements');
        $this->addSql('DROP TABLE participants');
        $this->addSql('DROP TABLE reponse');
        $this->addSql('DROP TABLE sponsors');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('ALTER TABLE association CHANGE photo photo VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE reclamation DROP date_en_jour');
    }
}
