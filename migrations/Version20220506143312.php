<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220506143312 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE possessions (id INT AUTO_INCREMENT NOT NULL, utilisateurs_id INT NOT NULL, nom VARCHAR(40) NOT NULL, valeur DOUBLE PRECISION NOT NULL, type VARCHAR(40) NOT NULL, INDEX IDX_832501881E969C5 (utilisateurs_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE possessions ADD CONSTRAINT FK_832501881E969C5 FOREIGN KEY (utilisateurs_id) REFERENCES utilisateurs (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE possessions');
    }
}
