<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220729192409 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DACFB3D99');
        // $this->addSql('DROP INDEX IDX_6EEAA67DACFB3D99 ON commande');
        // $this->addSql('ALTER TABLE commande DROP livraisons_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande ADD livraisons_id INT DEFAULT NULL');
    
      
    }
}
