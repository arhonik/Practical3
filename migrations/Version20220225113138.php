<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220225113138 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table for entity MovieShow';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE movie_show (id BINARY(16) NOT NULL, movie_title VARCHAR(255) NOT NULL, movie_duration VARCHAR(255) NOT NULL, schedule_start_at DATETIME NOT NULL, schedule_end_at DATETIME NOT NULL, hall_number_of_places INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE movie_show');
    }
}
