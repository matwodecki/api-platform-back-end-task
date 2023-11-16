<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231116191401 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE greeting_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE fixture_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE fixture (id INT NOT NULL, marka VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, nr_seryjny VARCHAR(255) NOT NULL, data_przyjecia TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, opis VARCHAR(1000) DEFAULT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN fixture.data_przyjecia IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('DROP TABLE greeting');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE fixture_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE greeting_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE greeting (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE fixture');
    }
}
