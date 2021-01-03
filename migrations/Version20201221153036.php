<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201221153036 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE delivery (id INT AUTO_INCREMENT NOT NULL, company_id_id INT NOT NULL, datetime VARCHAR(50) DEFAULT NULL, delivery_nr VARCHAR(50) DEFAULT NULL, pallets INT DEFAULT NULL, storage_area INT DEFAULT NULL, INDEX IDX_3781EC1038B53C32 (company_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, company_id_id INT NOT NULL, date VARCHAR(255) DEFAULT NULL, pallets INT DEFAULT NULL, weight DOUBLE PRECISION DEFAULT NULL, INDEX IDX_E52FFDEE38B53C32 (company_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE delivery ADD CONSTRAINT FK_3781EC1038B53C32 FOREIGN KEY (company_id_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE38B53C32 FOREIGN KEY (company_id_id) REFERENCES company (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE delivery');
        $this->addSql('DROP TABLE orders');
    }
}
