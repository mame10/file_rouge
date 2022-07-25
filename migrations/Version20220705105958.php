<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220705105958 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE produit_commande (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE commande_produit');
        $this->addSql('ALTER TABLE burger ADD CONSTRAINT FK_EFE35A0D9E6B9265 FOREIGN KEY (burger_menu_id) REFERENCES burger_menu (id)');
        $this->addSql('CREATE INDEX IDX_EFE35A0D9E6B9265 ON burger (burger_menu_id)');
        $this->addSql('ALTER TABLE burger_menu DROP FOREIGN KEY FK_E42E025CCD7E912');
        $this->addSql('ALTER TABLE burger_menu DROP FOREIGN KEY FK_E42E02517CE5090');
        $this->addSql('DROP INDEX IDX_E42E02517CE5090 ON burger_menu');
        $this->addSql('DROP INDEX IDX_E42E025CCD7E912 ON burger_menu');
        $this->addSql('ALTER TABLE burger_menu ADD id INT AUTO_INCREMENT NOT NULL, ADD quantite INT NOT NULL, DROP burger_id, DROP menu_id, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE commande ADD produit_commande_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DFCF26AD0 FOREIGN KEY (produit_commande_id) REFERENCES produit_commande (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67DFCF26AD0 ON commande (produit_commande_id)');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A93D9366A3');
        $this->addSql('DROP INDEX IDX_7D053A93D9366A3 ON menu');
        $this->addSql('ALTER TABLE menu CHANGE burher_menu_id burger_menu_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A939E6B9265 FOREIGN KEY (burger_menu_id) REFERENCES burger_menu (id)');
        $this->addSql('CREATE INDEX IDX_7D053A939E6B9265 ON menu (burger_menu_id)');
        $this->addSql('ALTER TABLE produit ADD produit_commande_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27FCF26AD0 FOREIGN KEY (produit_commande_id) REFERENCES produit_commande (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC27FCF26AD0 ON produit (produit_commande_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DFCF26AD0');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27FCF26AD0');
        $this->addSql('CREATE TABLE commande_produit (commande_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_DF1E9E8782EA2E54 (commande_id), INDEX IDX_DF1E9E87F347EFB (produit_id), PRIMARY KEY(commande_id, produit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE commande_produit ADD CONSTRAINT FK_DF1E9E87F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande_produit ADD CONSTRAINT FK_DF1E9E8782EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE produit_commande');
        $this->addSql('ALTER TABLE burger DROP FOREIGN KEY FK_EFE35A0D9E6B9265');
        $this->addSql('DROP INDEX IDX_EFE35A0D9E6B9265 ON burger');
        $this->addSql('ALTER TABLE burger_menu MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE burger_menu DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE burger_menu ADD menu_id INT NOT NULL, DROP id, CHANGE quantite burger_id INT NOT NULL');
        $this->addSql('ALTER TABLE burger_menu ADD CONSTRAINT FK_E42E025CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE burger_menu ADD CONSTRAINT FK_E42E02517CE5090 FOREIGN KEY (burger_id) REFERENCES burger (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_E42E02517CE5090 ON burger_menu (burger_id)');
        $this->addSql('CREATE INDEX IDX_E42E025CCD7E912 ON burger_menu (menu_id)');
        $this->addSql('ALTER TABLE burger_menu ADD PRIMARY KEY (burger_id, menu_id)');
        $this->addSql('DROP INDEX IDX_6EEAA67DFCF26AD0 ON commande');
        $this->addSql('ALTER TABLE commande DROP produit_commande_id');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A939E6B9265');
        $this->addSql('DROP INDEX IDX_7D053A939E6B9265 ON menu');
        $this->addSql('ALTER TABLE menu CHANGE burger_menu_id burher_menu_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A93D9366A3 FOREIGN KEY (burher_menu_id) REFERENCES burher_menu (id)');
        $this->addSql('CREATE INDEX IDX_7D053A93D9366A3 ON menu (burher_menu_id)');
        $this->addSql('DROP INDEX IDX_29A5EC27FCF26AD0 ON produit');
        $this->addSql('ALTER TABLE produit DROP produit_commande_id');
    }
}
