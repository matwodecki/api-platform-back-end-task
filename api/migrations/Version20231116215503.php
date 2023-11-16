<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231116215503 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $fixtures = [
            ['id' => '1', 'marka' => 'Bosch', 'model' => 'Wiertarka udarowa', 'nr_seryjny' => '1', 'data_przyjecia' => '2022-11-01', 'opis' => '', 'status' => 'nowe'],
            ['id' => '2', 'marka' => 'Bosch', 'model' => 'Akumulator', 'nr_seryjny' => '2', 'data_przyjecia' => '2022-11-02', 'opis' => '', 'status' => 'nowe'],
            ['id' => '3', 'marka' => 'LUX-TOOLS', 'model' => 'Wiertarko-wkrętarka', 'nr_seryjny' => '3', 'data_przyjecia' => '2022-11-03', 'opis' => '', 'status' => 'nowe'],
            ['id' => '4', 'marka' => 'LUX-TOOLS', 'model' => 'Szlifierka kątowa', 'nr_seryjny' => '4', 'data_przyjecia' => '2022-11-05', 'opis' => '', 'status' => 'nowe'],
            ['id' => '5', 'marka' => 'LUX-TOOLS', 'model' => 'Wiertarko-wkrętarka', 'nr_seryjny' => '5', 'data_przyjecia' => '2022-11-04', 'opis' => '', 'status' => 'nowe']
        ];
        foreach ($fixtures as $fixture) {
            $this->addSql('INSERT INTO FIXTURE VALUES(:id, :marka, :model, :nr_seryjny, :data_przyjecia, :opis, :status)', $fixture);
        }
    }

    public function down(Schema $schema): void
    {
        for ($id=1; $id <= 5; $id++) {
            $this->addSql('DELETE FROM FIXTURE WHERE id = '.$id);
        }
    }
}
