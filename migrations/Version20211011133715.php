<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211011133715 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE inscriptions (id INT AUTO_INCREMENT NOT NULL, sortie_id INT NOT NULL, participant_id INT NOT NULL, date_inscription DATETIME NOT NULL, INDEX IDX_74E0281CCC72D953 (sortie_id), INDEX IDX_74E0281C9D1C3019 (participant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inscriptions ADD CONSTRAINT FK_74E0281CCC72D953 FOREIGN KEY (sortie_id) REFERENCES sorties (id)');
        $this->addSql('ALTER TABLE inscriptions ADD CONSTRAINT FK_74E0281C9D1C3019 FOREIGN KEY (participant_id) REFERENCES participants (id)');
        $this->addSql('DROP TABLE sorties_participants');
        $this->addSql('ALTER TABLE lieux CHANGE ville_id ville_id INT NOT NULL');
        $this->addSql('ALTER TABLE participants CHANGE site_id site_id INT NOT NULL');
        $this->addSql('ALTER TABLE sorties DROP FOREIGN KEY FK_488163E87EE5403C');
        $this->addSql('DROP INDEX IDX_488163E87EE5403C ON sorties');
        $this->addSql('ALTER TABLE sorties ADD organisateur_id INT NOT NULL, DROP administrateur_id, CHANGE etat_id etat_id INT NOT NULL, CHANGE lieu_id lieu_id INT NOT NULL, CHANGE site_id site_id INT NOT NULL');
        $this->addSql('ALTER TABLE sorties ADD CONSTRAINT FK_488163E8D936B2FA FOREIGN KEY (organisateur_id) REFERENCES participants (id)');
        $this->addSql('CREATE INDEX IDX_488163E8D936B2FA ON sorties (organisateur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sorties_participants (sorties_id INT NOT NULL, participants_id INT NOT NULL, INDEX IDX_BB662DEC15DFCFB2 (sorties_id), INDEX IDX_BB662DEC838709D5 (participants_id), PRIMARY KEY(sorties_id, participants_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE sorties_participants ADD CONSTRAINT FK_BB662DEC15DFCFB2 FOREIGN KEY (sorties_id) REFERENCES sorties (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sorties_participants ADD CONSTRAINT FK_BB662DEC838709D5 FOREIGN KEY (participants_id) REFERENCES participants (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE inscriptions');
        $this->addSql('ALTER TABLE lieux CHANGE ville_id ville_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE participants CHANGE site_id site_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sorties DROP FOREIGN KEY FK_488163E8D936B2FA');
        $this->addSql('DROP INDEX IDX_488163E8D936B2FA ON sorties');
        $this->addSql('ALTER TABLE sorties ADD administrateur_id INT DEFAULT NULL, DROP organisateur_id, CHANGE etat_id etat_id INT DEFAULT NULL, CHANGE lieu_id lieu_id INT DEFAULT NULL, CHANGE site_id site_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sorties ADD CONSTRAINT FK_488163E87EE5403C FOREIGN KEY (administrateur_id) REFERENCES participants (id)');
        $this->addSql('CREATE INDEX IDX_488163E87EE5403C ON sorties (administrateur_id)');
    }
}
