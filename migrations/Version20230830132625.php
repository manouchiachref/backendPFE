<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230830132625 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE request (id INT AUTO_INCREMENT NOT NULL, pro_id INT DEFAULT NULL, project_id INT DEFAULT NULL, status TINYINT(1) NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_3B978F9FC3B7E4BA (pro_id), INDEX IDX_3B978F9F166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE request ADD CONSTRAINT FK_3B978F9FC3B7E4BA FOREIGN KEY (pro_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE request ADD CONSTRAINT FK_3B978F9F166D1F9C FOREIGN KEY (project_id) REFERENCES projet (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE request DROP FOREIGN KEY FK_3B978F9FC3B7E4BA');
        $this->addSql('ALTER TABLE request DROP FOREIGN KEY FK_3B978F9F166D1F9C');
        $this->addSql('DROP TABLE request');
    }
}
