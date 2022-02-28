<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20220228133135 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table for entity Ticket';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE ticket (id BINARY(16) NOT NULL, movie_show_id BINARY(16) DEFAULT NULL, movie VARCHAR(255) NOT NULL, start_time DATETIME NOT NULL, customer_name VARCHAR(255) NOT NULL, customer_phone VARCHAR(255) NOT NULL, INDEX IDX_97A0ADA3F057BE4A (movie_show_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3F057BE4A FOREIGN KEY (movie_show_id) REFERENCES movie_show (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3F057BE4A');
        $this->addSql('DROP TABLE ticket');
    }
}