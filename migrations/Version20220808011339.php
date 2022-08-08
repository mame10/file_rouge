<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220808011339 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE portion_commande DROP FOREIGN KEY FK_4BFDE8DFF347EFB');
        $this->addSql('DROP INDEX IDX_4BFDE8DFF347EFB ON portion_commande');
        $this->addSql('ALTER TABLE portion_commande DROP produit_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE portion_commande ADD produit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE portion_commande ADD CONSTRAINT FK_4BFDE8DFF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('CREATE INDEX IDX_4BFDE8DFF347EFB ON portion_commande (produit_id)');
    }
}
