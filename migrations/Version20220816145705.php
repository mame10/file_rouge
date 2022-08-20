<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220816145705 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande CHANGE date date DATE NOT NULL');
        $this->addSql('ALTER TABLE commande_taille_boisson DROP FOREIGN KEY FK_9CA1CDB2734B8089');
        $this->addSql('DROP INDEX IDX_9CA1CDB2734B8089 ON commande_taille_boisson');
        $this->addSql('ALTER TABLE commande_taille_boisson CHANGE boisson_id taille_boisson_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande_taille_boisson ADD CONSTRAINT FK_9CA1CDB28421F13F FOREIGN KEY (taille_boisson_id) REFERENCES taille_boisson (id)');
        $this->addSql('CREATE INDEX IDX_9CA1CDB28421F13F ON commande_taille_boisson (taille_boisson_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande CHANGE date date VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE commande_taille_boisson DROP FOREIGN KEY FK_9CA1CDB28421F13F');
        $this->addSql('DROP INDEX IDX_9CA1CDB28421F13F ON commande_taille_boisson');
        $this->addSql('ALTER TABLE commande_taille_boisson CHANGE taille_boisson_id boisson_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande_taille_boisson ADD CONSTRAINT FK_9CA1CDB2734B8089 FOREIGN KEY (boisson_id) REFERENCES taille_boisson (id)');
        $this->addSql('CREATE INDEX IDX_9CA1CDB2734B8089 ON commande_taille_boisson (boisson_id)');
    }
}
