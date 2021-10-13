<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211013093435 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE inscription (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE particpant (id INT AUTO_INCREMENT NOT NULL, sites_no_site_id INT NOT NULL, pseudo VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, telephone VARCHAR(15) DEFAULT NULL, mail VARCHAR(100) NOT NULL, administrateur TINYINT(1) NOT NULL, actif TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_D7DCBB5486CC499D (pseudo), INDEX IDX_D7DCBB54DDF76323 (sites_no_site_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE particpant ADD CONSTRAINT FK_D7DCBB54DDF76323 FOREIGN KEY (sites_no_site_id) REFERENCES site (id)');
        $this->addSql('ALTER TABLE inscriptions DROP FOREIGN KEY FK_74E0281C9D1C3019');
        $this->addSql('DROP INDEX IDX_74E0281C9D1C3019 ON inscriptions');
        $this->addSql('ALTER TABLE inscriptions CHANGE participant_id participants_no_participant_id INT NOT NULL');
        $this->addSql('ALTER TABLE inscriptions ADD CONSTRAINT FK_74E0281CACA3F17D FOREIGN KEY (participants_no_participant_id) REFERENCES particpant (id)');
        $this->addSql('CREATE INDEX IDX_74E0281CACA3F17D ON inscriptions (participants_no_participant_id)');
        $this->addSql('ALTER TABLE participants DROP FOREIGN KEY FK_71697092F6BD1646');
        $this->addSql('DROP INDEX IDX_71697092F6BD1646 ON participants');
        $this->addSql('ALTER TABLE participants DROP site_id');
        $this->addSql('ALTER TABLE sorties DROP FOREIGN KEY FK_488163E8D936B2FA');
        $this->addSql('ALTER TABLE sorties ADD CONSTRAINT FK_488163E8D936B2FA FOREIGN KEY (organisateur_id) REFERENCES particpant (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscriptions DROP FOREIGN KEY FK_74E0281CACA3F17D');
        $this->addSql('ALTER TABLE sorties DROP FOREIGN KEY FK_488163E8D936B2FA');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('DROP TABLE particpant');
        $this->addSql('DROP INDEX IDX_74E0281CACA3F17D ON inscriptions');
        $this->addSql('ALTER TABLE inscriptions CHANGE participants_no_participant_id participant_id INT NOT NULL');
        $this->addSql('ALTER TABLE inscriptions ADD CONSTRAINT FK_74E0281C9D1C3019 FOREIGN KEY (participant_id) REFERENCES participants (id)');
        $this->addSql('CREATE INDEX IDX_74E0281C9D1C3019 ON inscriptions (participant_id)');
        $this->addSql('ALTER TABLE participants ADD site_id INT NOT NULL');
        $this->addSql('ALTER TABLE participants ADD CONSTRAINT FK_71697092F6BD1646 FOREIGN KEY (site_id) REFERENCES site (id)');
        $this->addSql('CREATE INDEX IDX_71697092F6BD1646 ON participants (site_id)');
        $this->addSql('ALTER TABLE sorties DROP FOREIGN KEY FK_488163E8D936B2FA');
        $this->addSql('ALTER TABLE sorties ADD CONSTRAINT FK_488163E8D936B2FA FOREIGN KEY (organisateur_id) REFERENCES participants (id)');
    }
}
