<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240603202245 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD lastname VARCHAR(255) NOT NULL, ADD numtel VARCHAR(255) NOT NULL, DROP status, CHANGE created_date created_date DATETIME DEFAULT NULL, CHANGE is_verified is_verified TINYINT(1) DEFAULT NULL, CHANGE name firstname VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD name VARCHAR(255) NOT NULL, ADD status INT NOT NULL, DROP firstname, DROP lastname, DROP numtel, CHANGE created_date created_date DATETIME NOT NULL, CHANGE is_verified is_verified TINYINT(1) NOT NULL');
    }
}
