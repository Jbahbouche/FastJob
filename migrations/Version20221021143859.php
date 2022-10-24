<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221021143859 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annonce_competence (annonce_id INT NOT NULL, competence_id INT NOT NULL, INDEX IDX_8AA0BDFC8805AB2F (annonce_id), INDEX IDX_8AA0BDFC15761DAB (competence_id), PRIMARY KEY(annonce_id, competence_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE departement (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, numero VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annonce_competence ADD CONSTRAINT FK_8AA0BDFC8805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE annonce_competence ADD CONSTRAINT FK_8AA0BDFC15761DAB FOREIGN KEY (competence_id) REFERENCES competence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE annonce ADD departement_id INT NOT NULL, DROP departement');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5CCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id)');
        $this->addSql('CREATE INDEX IDX_F65593E5CCF9E01E ON annonce (departement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5CCF9E01E');
        $this->addSql('DROP TABLE annonce_competence');
        $this->addSql('DROP TABLE departement');
        $this->addSql('DROP INDEX IDX_F65593E5CCF9E01E ON annonce');
        $this->addSql('ALTER TABLE annonce ADD departement VARCHAR(255) NOT NULL, DROP departement_id');
    }
}
