<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221021075011 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E514E7B6CD');
        $this->addSql('DROP TABLE sousdomaine');
        $this->addSql('DROP INDEX IDX_F65593E514E7B6CD ON annonce');
        $this->addSql('ALTER TABLE annonce DROP sousdomaine_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sousdomaine (id INT AUTO_INCREMENT NOT NULL, domaine_id INT DEFAULT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_51831FB84272FC9F (domaine_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE sousdomaine ADD CONSTRAINT FK_51831FB84272FC9F FOREIGN KEY (domaine_id) REFERENCES domaine (id)');
        $this->addSql('ALTER TABLE annonce ADD sousdomaine_id INT NOT NULL');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E514E7B6CD FOREIGN KEY (sousdomaine_id) REFERENCES sousdomaine (id)');
        $this->addSql('CREATE INDEX IDX_F65593E514E7B6CD ON annonce (sousdomaine_id)');
    }
}
