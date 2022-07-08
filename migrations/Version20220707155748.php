<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220707155748 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE boisson_commande (id INT AUTO_INCREMENT NOT NULL, boisson_id INT DEFAULT NULL, commande_id INT DEFAULT NULL, quantite INT NOT NULL, INDEX IDX_98ACF766734B8089 (boisson_id), INDEX IDX_98ACF76682EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE burger_commande (id INT AUTO_INCREMENT NOT NULL, burger_id INT DEFAULT NULL, commande_id INT DEFAULT NULL, quantity INT NOT NULL, INDEX IDX_A0D9FE9917CE5090 (burger_id), INDEX IDX_A0D9FE9982EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_commande (id INT AUTO_INCREMENT NOT NULL, menu_id INT DEFAULT NULL, commande_id INT DEFAULT NULL, quantite INT NOT NULL, INDEX IDX_42BBE3EBCCD7E912 (menu_id), INDEX IDX_42BBE3EB82EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE portion_commande (id INT AUTO_INCREMENT NOT NULL, portion_id INT DEFAULT NULL, commande_id INT DEFAULT NULL, quantite INT NOT NULL, INDEX IDX_4BFDE8DF162BE352 (portion_id), INDEX IDX_4BFDE8DF82EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE boisson_commande ADD CONSTRAINT FK_98ACF766734B8089 FOREIGN KEY (boisson_id) REFERENCES boisson (id)');
        $this->addSql('ALTER TABLE boisson_commande ADD CONSTRAINT FK_98ACF76682EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE burger_commande ADD CONSTRAINT FK_A0D9FE9917CE5090 FOREIGN KEY (burger_id) REFERENCES burger (id)');
        $this->addSql('ALTER TABLE burger_commande ADD CONSTRAINT FK_A0D9FE9982EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE menu_commande ADD CONSTRAINT FK_42BBE3EBCCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE menu_commande ADD CONSTRAINT FK_42BBE3EB82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE portion_commande ADD CONSTRAINT FK_4BFDE8DF162BE352 FOREIGN KEY (portion_id) REFERENCES portion_frite (id)');
        $this->addSql('ALTER TABLE portion_commande ADD CONSTRAINT FK_4BFDE8DF82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('DROP TABLE produit_commande');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE produit_commande (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, commande_id INT DEFAULT NULL, produit_id INT DEFAULT NULL, quantite_produit INT NOT NULL, INDEX IDX_47F5946EA76ED395 (user_id), INDEX IDX_47F5946E82EA2E54 (commande_id), INDEX IDX_47F5946EF347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE produit_commande ADD CONSTRAINT FK_47F5946EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE produit_commande ADD CONSTRAINT FK_47F5946E82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE produit_commande ADD CONSTRAINT FK_47F5946EF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('DROP TABLE boisson_commande');
        $this->addSql('DROP TABLE burger_commande');
        $this->addSql('DROP TABLE menu_commande');
        $this->addSql('DROP TABLE portion_commande');
    }
}
