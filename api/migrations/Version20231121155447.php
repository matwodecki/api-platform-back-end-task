<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231121155447 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $fixtures = [
            ['id' => '1', 'brand' => 'Bosch', 'model' => 'Wiertarka udarowa', 'serial_number' => '1', 'order_date' => '2022-11-01', 'description' => '', 'status' => 'nowe'],
            ['id' => '2', 'brand' => 'Bosch', 'model' => 'Akumulator', 'serial_number' => '2', 'order_date' => '2022-11-02', 'description' => '', 'status' => 'nowe'],
            ['id' => '3', 'brand' => 'LUX-TOOLS', 'model' => 'Wiertarko-wkrętarka', 'serial_number' => '3', 'order_date' => '2022-11-03', 'description' => '', 'status' => 'nowe'],
            ['id' => '4', 'brand' => 'LUX-TOOLS', 'model' => 'Szlifierka kątowa', 'serial_number' => '4', 'order_date' => '2022-11-05', 'description' => '', 'status' => 'nowe'],
            ['id' => '5', 'brand' => 'LUX-TOOLS', 'model' => 'Wiertarko-wkrętarka', 'serial_number' => '5', 'order_date' => '2022-11-04', 'description' => '', 'status' => 'nowe']
        ];
        foreach ($fixtures as $fixture) {
            $this->addSql('INSERT INTO FIXTURE VALUES(:id, :brand, :model, :serial_number, :order_date, :description, :status)', $fixture);
        }
        $this->addSql('ALTER SEQUENCE fixture_id_seq RESTART WITH 6');
        $user = ['id' => '1', 'email' => 'user@example.com', 'password' => '$2y$13$cNwf8ATcM30p.45ey0lL.u7PZg1x85AB9NKEnH89vi/MyjYUDCYty', 'roles' => '[]']; // password
        $this->addSql('INSERT INTO public.user VALUES(:id, :email, :password, :roles)', $user);
        $this->addSql('ALTER SEQUENCE user_id_seq RESTART WITH 2');
    }

    public function down(Schema $schema): void
    {
        for ($id=1; $id <= 5; $id++) {
            $this->addSql('DELETE FROM FIXTURE WHERE id = '.$id);
        }
        $this->addSql('DELETE FROM USER WHERE id = 1');
    }
}
