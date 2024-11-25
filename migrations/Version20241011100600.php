<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241011100600 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE groceries_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE groceries (id INT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(50) NOT NULL, quantity INT NOT NULL, unit VARCHAR(10) DEFAULT \'g\', PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE groceries_id_seq CASCADE');
        $this->addSql('DROP TABLE groceries');
    }
}
