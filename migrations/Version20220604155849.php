<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220604155849 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annonce (id INT AUTO_INCREMENT NOT NULL, contrat_id INT NOT NULL, domaine_id INT NOT NULL, sousdomaine_id INT NOT NULL, societe_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, profil LONGTEXT NOT NULL, competence LONGTEXT NOT NULL, salaire DOUBLE PRECISION NOT NULL, ville VARCHAR(255) NOT NULL, departement VARCHAR(255) NOT NULL, INDEX IDX_F65593E51823061F (contrat_id), INDEX IDX_F65593E54272FC9F (domaine_id), INDEX IDX_F65593E514E7B6CD (sousdomaine_id), INDEX IDX_F65593E5FCF77503 (societe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE atouts (id INT AUTO_INCREMENT NOT NULL, cv_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_CD18EAC9CFE419E2 (cv_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE candidat (id INT AUTO_INCREMENT NOT NULL, cv_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, naissance VARCHAR(255) NOT NULL, cv_pdf VARCHAR(255) DEFAULT NULL, presentation LONGTEXT DEFAULT NULL, telephone VARCHAR(255) DEFAULT NULL, recherche VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_6AB5B471CFE419E2 (cv_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contrat (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cv (id INT AUTO_INCREMENT NOT NULL, interets LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE domaine (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE experience (id INT AUTO_INCREMENT NOT NULL, cv_id INT DEFAULT NULL, mois_deb VARCHAR(255) NOT NULL, annee_deb INT NOT NULL, mois_fin VARCHAR(255) NOT NULL, annee_fin INT NOT NULL, poste VARCHAR(255) NOT NULL, lieu VARCHAR(255) DEFAULT NULL, missions LONGTEXT DEFAULT NULL, INDEX IDX_590C103CFE419E2 (cv_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, cv_id INT DEFAULT NULL, date INT NOT NULL, diplome VARCHAR(255) NOT NULL, lieu VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_404021BFCFE419E2 (cv_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE postulation (id INT AUTO_INCREMENT NOT NULL, annonce_id INT DEFAULT NULL, candidat_id INT DEFAULT NULL, message LONGTEXT DEFAULT NULL, statut VARCHAR(255) DEFAULT NULL, INDEX IDX_DA7D4E9B8805AB2F (annonce_id), INDEX IDX_DA7D4E9B8D0EB82 (candidat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE societe (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, representant_nom VARCHAR(255) NOT NULL, representant_prenom VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, logo VARCHAR(255) DEFAULT NULL, site VARCHAR(255) DEFAULT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sousdomaine (id INT AUTO_INCREMENT NOT NULL, domaine_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_51831FB84272FC9F (domaine_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, candidat_id INT DEFAULT NULL, societe_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, role JSON NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D6498D0EB82 (candidat_id), UNIQUE INDEX UNIQ_8D93D649FCF77503 (societe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E51823061F FOREIGN KEY (contrat_id) REFERENCES contrat (id)');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E54272FC9F FOREIGN KEY (domaine_id) REFERENCES domaine (id)');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E514E7B6CD FOREIGN KEY (sousdomaine_id) REFERENCES sousdomaine (id)');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5FCF77503 FOREIGN KEY (societe_id) REFERENCES societe (id)');
        $this->addSql('ALTER TABLE atouts ADD CONSTRAINT FK_CD18EAC9CFE419E2 FOREIGN KEY (cv_id) REFERENCES cv (id)');
        $this->addSql('ALTER TABLE candidat ADD CONSTRAINT FK_6AB5B471CFE419E2 FOREIGN KEY (cv_id) REFERENCES cv (id)');
        $this->addSql('ALTER TABLE experience ADD CONSTRAINT FK_590C103CFE419E2 FOREIGN KEY (cv_id) REFERENCES cv (id)');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BFCFE419E2 FOREIGN KEY (cv_id) REFERENCES cv (id)');
        $this->addSql('ALTER TABLE postulation ADD CONSTRAINT FK_DA7D4E9B8805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id)');
        $this->addSql('ALTER TABLE postulation ADD CONSTRAINT FK_DA7D4E9B8D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id)');
        $this->addSql('ALTER TABLE sousdomaine ADD CONSTRAINT FK_51831FB84272FC9F FOREIGN KEY (domaine_id) REFERENCES domaine (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6498D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649FCF77503 FOREIGN KEY (societe_id) REFERENCES societe (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE postulation DROP FOREIGN KEY FK_DA7D4E9B8805AB2F');
        $this->addSql('ALTER TABLE postulation DROP FOREIGN KEY FK_DA7D4E9B8D0EB82');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6498D0EB82');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E51823061F');
        $this->addSql('ALTER TABLE atouts DROP FOREIGN KEY FK_CD18EAC9CFE419E2');
        $this->addSql('ALTER TABLE candidat DROP FOREIGN KEY FK_6AB5B471CFE419E2');
        $this->addSql('ALTER TABLE experience DROP FOREIGN KEY FK_590C103CFE419E2');
        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY FK_404021BFCFE419E2');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E54272FC9F');
        $this->addSql('ALTER TABLE sousdomaine DROP FOREIGN KEY FK_51831FB84272FC9F');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5FCF77503');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649FCF77503');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E514E7B6CD');
        $this->addSql('DROP TABLE annonce');
        $this->addSql('DROP TABLE atouts');
        $this->addSql('DROP TABLE candidat');
        $this->addSql('DROP TABLE contrat');
        $this->addSql('DROP TABLE cv');
        $this->addSql('DROP TABLE domaine');
        $this->addSql('DROP TABLE experience');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE postulation');
        $this->addSql('DROP TABLE societe');
        $this->addSql('DROP TABLE sousdomaine');
        $this->addSql('DROP TABLE user');
    }
}
