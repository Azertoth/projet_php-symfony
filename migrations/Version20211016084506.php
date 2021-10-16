<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211016084506 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscriptions DROP FOREIGN KEY FK_74E0281CACA3F17D');
        $this->addSql('DROP INDEX IDX_74E0281CACA3F17D ON inscriptions');
        $this->addSql('ALTER TABLE inscriptions CHANGE participants_no_participant_id participants_id INT NOT NULL');
        $this->addSql('ALTER TABLE inscriptions ADD CONSTRAINT FK_74E0281C838709D5 FOREIGN KEY (participants_id) REFERENCES particpant (id)');
        $this->addSql('CREATE INDEX IDX_74E0281C838709D5 ON inscriptions (participants_id)');
        $this->addSql('ALTER TABLE particpant DROP FOREIGN KEY FK_D7DCBB54DDF76323');
        $this->addSql('DROP INDEX IDX_D7DCBB54DDF76323 ON particpant');
        $this->addSql('ALTER TABLE particpant DROP sites_no_site_id');
        $this->addSql('ALTER TABLE sorties DROP FOREIGN KEY FK_488163E86AB213CC');
        $this->addSql('DROP INDEX IDX_488163E86AB213CC ON sorties');
        $this->addSql('ALTER TABLE sorties CHANGE etat_id etat_id INT DEFAULT NULL, CHANGE etat_sortir etat_sortir VARCHAR(255) NOT NULL, CHANGE lieu_id lieux_id INT NOT NULL');
        $this->addSql('ALTER TABLE sorties ADD CONSTRAINT FK_488163E8A2C806AC FOREIGN KEY (lieux_id) REFERENCES lieux (id)');
        $this->addSql('CREATE INDEX IDX_488163E8A2C806AC ON sorties (lieux_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscriptions DROP FOREIGN KEY FK_74E0281C838709D5');
        $this->addSql('DROP INDEX IDX_74E0281C838709D5 ON inscriptions');
        $this->addSql('ALTER TABLE inscriptions CHANGE participants_id participants_no_participant_id INT NOT NULL');
        $this->addSql('ALTER TABLE inscriptions ADD CONSTRAINT FK_74E0281CACA3F17D FOREIGN KEY (participants_no_participant_id) REFERENCES particpant (id)');
        $this->addSql('CREATE INDEX IDX_74E0281CACA3F17D ON inscriptions (participants_no_participant_id)');
        $this->addSql('ALTER TABLE particpant ADD sites_no_site_id INT NOT NULL');
        $this->addSql('ALTER TABLE particpant ADD CONSTRAINT FK_D7DCBB54DDF76323 FOREIGN KEY (sites_no_site_id) REFERENCES site (id)');
        $this->addSql('CREATE INDEX IDX_D7DCBB54DDF76323 ON particpant (sites_no_site_id)');
        $this->addSql('ALTER TABLE sorties DROP FOREIGN KEY FK_488163E8A2C806AC');
        $this->addSql('DROP INDEX IDX_488163E8A2C806AC ON sorties');
        $this->addSql('ALTER TABLE sorties CHANGE etat_id etat_id INT NOT NULL, CHANGE etat_sortir etat_sortir INT DEFAULT NULL, CHANGE lieux_id lieu_id INT NOT NULL');
        $this->addSql('ALTER TABLE sorties ADD CONSTRAINT FK_488163E86AB213CC FOREIGN KEY (lieu_id) REFERENCES lieux (id)');
        $this->addSql('CREATE INDEX IDX_488163E86AB213CC ON sorties (lieu_id)');
    }
}
