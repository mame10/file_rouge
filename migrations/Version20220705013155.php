<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220705013155 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE boisson_taille (boisson_id INT NOT NULL, taille_id INT NOT NULL, INDEX IDX_E7A2EE1734B8089 (boisson_id), INDEX IDX_E7A2EE1FF25611A (taille_id), PRIMARY KEY(boisson_id, taille_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE boisson_taille ADD CONSTRAINT FK_E7A2EE1734B8089 FOREIGN KEY (boisson_id) REFERENCES boisson (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE boisson_taille ADD CONSTRAINT FK_E7A2EE1FF25611A FOREIGN KEY (taille_id) REFERENCES taille (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE boisson DROP taile');
        $this->addSql('ALTER TABLE burger DROP FOREIGN KEY FK_EFE35A0DD9366A3');
        $this->addSql('DROP INDEX IDX_EFE35A0DD9366A3 ON burger');
        $this->addSql('ALTER TABLE burger CHANGE burher_menu_id burger_menu_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE burger ADD CONSTRAINT FK_EFE35A0D9E6B9265 FOREIGN KEY (burger_menu_id) REFERENCES burger_menu (id)');
        $this->addSql('CREATE INDEX IDX_EFE35A0D9E6B9265 ON burger (burger_menu_id)');
        $this->addSql('ALTER TABLE burger_menu DROP FOREIGN KEY FK_E42E025CCD7E912');
        $this->addSql('ALTER TABLE burger_menu DROP FOREIGN KEY FK_E42E02517CE5090');
        $this->addSql('DROP INDEX IDX_E42E025CCD7E912 ON burger_menu');
        $this->addSql('DROP INDEX IDX_E42E02517CE5090 ON burger_menu');
        $this->addSql('ALTER TABLE burger_menu ADD id INT AUTO_INCREMENT NOT NULL, ADD quantite INT NOT NULL, DROP burger_id, DROP menu_id, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A93D9366A3');
        $this->addSql('DROP INDEX IDX_7D053A93D9366A3 ON menu');
        $this->addSql('ALTER TABLE menu CHANGE burher_menu_id burger_menu_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A939E6B9265 FOREIGN KEY (burger_menu_id) REFERENCES burger_menu (id)');
        $this->addSql('CREATE INDEX IDX_7D053A939E6B9265 ON menu (burger_menu_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE boisson_taille');
        $this->addSql('ALTER TABLE boisson ADD taile VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE burger DROP FOREIGN KEY FK_EFE35A0D9E6B9265');
        $this->addSql('DROP INDEX IDX_EFE35A0D9E6B9265 ON burger');
        $this->addSql('ALTER TABLE burger CHANGE burger_menu_id burher_menu_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE burger ADD CONSTRAINT FK_EFE35A0DD9366A3 FOREIGN KEY (burher_menu_id) REFERENCES burher_menu (id)');
        $this->addSql('CREATE INDEX IDX_EFE35A0DD9366A3 ON burger (burher_menu_id)');
        $this->addSql('ALTER TABLE burger_menu MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE burger_menu DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE burger_menu ADD menu_id INT NOT NULL, DROP id, CHANGE quantite burger_id INT NOT NULL');
        $this->addSql('ALTER TABLE burger_menu ADD CONSTRAINT FK_E42E025CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE burger_menu ADD CONSTRAINT FK_E42E02517CE5090 FOREIGN KEY (burger_id) REFERENCES burger (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_E42E025CCD7E912 ON burger_menu (menu_id)');
        $this->addSql('CREATE INDEX IDX_E42E02517CE5090 ON burger_menu (burger_id)');
        $this->addSql('ALTER TABLE burger_menu ADD PRIMARY KEY (burger_id, menu_id)');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A939E6B9265');
        $this->addSql('DROP INDEX IDX_7D053A939E6B9265 ON menu');
        $this->addSql('ALTER TABLE menu CHANGE burger_menu_id burher_menu_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A93D9366A3 FOREIGN KEY (burher_menu_id) REFERENCES burher_menu (id)');
        $this->addSql('CREATE INDEX IDX_7D053A93D9366A3 ON menu (burher_menu_id)');
    }
}
