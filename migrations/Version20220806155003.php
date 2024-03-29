<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220806155003 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande_taille_boisson (id INT AUTO_INCREMENT NOT NULL, commande_id INT DEFAULT NULL, boisson_id INT DEFAULT NULL, quantite_commande INT NOT NULL, INDEX IDX_9CA1CDB282EA2E54 (commande_id), INDEX IDX_9CA1CDB2734B8089 (boisson_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande_taille_boisson ADD CONSTRAINT FK_9CA1CDB282EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE commande_taille_boisson ADD CONSTRAINT FK_9CA1CDB2734B8089 FOREIGN KEY (boisson_id) REFERENCES taille_boisson (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE commande_taille_boisson');
    }
}
