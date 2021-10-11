<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211011144835 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE etats (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscriptions (id INT AUTO_INCREMENT NOT NULL, sortie_id INT NOT NULL, participant_id INT NOT NULL, date_inscription DATETIME NOT NULL, INDEX IDX_74E0281CCC72D953 (sortie_id), INDEX IDX_74E0281C9D1C3019 (participant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lieux (id INT AUTO_INCREMENT NOT NULL, ville_id INT NOT NULL, nom_lieu VARCHAR(30) NOT NULL, rue VARCHAR(30) DEFAULT NULL, latitude DOUBLE PRECISION DEFAULT NULL, longitude DOUBLE PRECISION DEFAULT NULL, INDEX IDX_9E44A8AEA73F0036 (ville_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participants (id INT AUTO_INCREMENT NOT NULL, site_id INT NOT NULL, pseudo VARCHAR(30) NOT NULL, nom VARCHAR(30) NOT NULL, prenom VARCHAR(30) NOT NULL, telephone VARCHAR(15) DEFAULT NULL, mail VARCHAR(20) NOT NULL, mot_de_passe VARCHAR(20) NOT NULL, administrateur TINYINT(1) NOT NULL, actif TINYINT(1) NOT NULL, INDEX IDX_71697092F6BD1646 (site_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE site (id INT AUTO_INCREMENT NOT NULL, nom_site VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sorties (id INT AUTO_INCREMENT NOT NULL, etat_id INT NOT NULL, lieu_id INT NOT NULL, site_id INT NOT NULL, organisateur_id INT NOT NULL, nom_sortie VARCHAR(30) NOT NULL, date_heure_debut DATETIME NOT NULL, duree INT DEFAULT NULL, date_limite_inscription DATETIME NOT NULL, nb_inscriptions_max INT NOT NULL, infos_sortie VARCHAR(500) DEFAULT NULL, etat_sortir INT DEFAULT NULL, url_photo VARCHAR(250) DEFAULT NULL, INDEX IDX_488163E8D5E86FF (etat_id), INDEX IDX_488163E86AB213CC (lieu_id), INDEX IDX_488163E8F6BD1646 (site_id), INDEX IDX_488163E8D936B2FA (organisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE villes (id INT AUTO_INCREMENT NOT NULL, nom_ville VARCHAR(30) NOT NULL, code_postal VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inscriptions ADD CONSTRAINT FK_74E0281CCC72D953 FOREIGN KEY (sortie_id) REFERENCES sorties (id)');
        $this->addSql('ALTER TABLE inscriptions ADD CONSTRAINT FK_74E0281C9D1C3019 FOREIGN KEY (participant_id) REFERENCES participants (id)');
        $this->addSql('ALTER TABLE lieux ADD CONSTRAINT FK_9E44A8AEA73F0036 FOREIGN KEY (ville_id) REFERENCES villes (id)');
        $this->addSql('ALTER TABLE participants ADD CONSTRAINT FK_71697092F6BD1646 FOREIGN KEY (site_id) REFERENCES site (id)');
        $this->addSql('ALTER TABLE sorties ADD CONSTRAINT FK_488163E8D5E86FF FOREIGN KEY (etat_id) REFERENCES etats (id)');
        $this->addSql('ALTER TABLE sorties ADD CONSTRAINT FK_488163E86AB213CC FOREIGN KEY (lieu_id) REFERENCES lieux (id)');
        $this->addSql('ALTER TABLE sorties ADD CONSTRAINT FK_488163E8F6BD1646 FOREIGN KEY (site_id) REFERENCES site (id)');
        $this->addSql('ALTER TABLE sorties ADD CONSTRAINT FK_488163E8D936B2FA FOREIGN KEY (organisateur_id) REFERENCES participants (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sorties DROP FOREIGN KEY FK_488163E8D5E86FF');
        $this->addSql('ALTER TABLE sorties DROP FOREIGN KEY FK_488163E86AB213CC');
        $this->addSql('ALTER TABLE inscriptions DROP FOREIGN KEY FK_74E0281C9D1C3019');
        $this->addSql('ALTER TABLE sorties DROP FOREIGN KEY FK_488163E8D936B2FA');
        $this->addSql('ALTER TABLE participants DROP FOREIGN KEY FK_71697092F6BD1646');
        $this->addSql('ALTER TABLE sorties DROP FOREIGN KEY FK_488163E8F6BD1646');
        $this->addSql('ALTER TABLE inscriptions DROP FOREIGN KEY FK_74E0281CCC72D953');
        $this->addSql('ALTER TABLE lieux DROP FOREIGN KEY FK_9E44A8AEA73F0036');
        $this->addSql('DROP TABLE etats');
        $this->addSql('DROP TABLE inscriptions');
        $this->addSql('DROP TABLE lieux');
        $this->addSql('DROP TABLE participants');
        $this->addSql('DROP TABLE site');
        $this->addSql('DROP TABLE sorties');
        $this->addSql('DROP TABLE villes');
    }
}
