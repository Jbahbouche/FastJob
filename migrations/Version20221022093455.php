<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221022093455 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE candidat_competence (candidat_id INT NOT NULL, competence_id INT NOT NULL, INDEX IDX_CF607D68D0EB82 (candidat_id), INDEX IDX_CF607D615761DAB (competence_id), PRIMARY KEY(candidat_id, competence_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE candidat_competence ADD CONSTRAINT FK_CF607D68D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE candidat_competence ADD CONSTRAINT FK_CF607D615761DAB FOREIGN KEY (competence_id) REFERENCES competence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE candidat ADD domaine_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE candidat ADD CONSTRAINT FK_6AB5B4714272FC9F FOREIGN KEY (domaine_id) REFERENCES domaine (id)');
        $this->addSql('CREATE INDEX IDX_6AB5B4714272FC9F ON candidat (domaine_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE candidat_competence');
        $this->addSql('ALTER TABLE candidat DROP FOREIGN KEY FK_6AB5B4714272FC9F');
        $this->addSql('DROP INDEX IDX_6AB5B4714272FC9F ON candidat');
        $this->addSql('ALTER TABLE candidat DROP domaine_id');
    }
}
