<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201220112434 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE attendence (id INT AUTO_INCREMENT NOT NULL, mitarbeiter_id_id INT NOT NULL, date DATETIME NOT NULL, status VARCHAR(50) NOT NULL, INDEX IDX_E2819AC6C9C1579C (mitarbeiter_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE attendence ADD CONSTRAINT FK_E2819AC6C9C1579C FOREIGN KEY (mitarbeiter_id_id) REFERENCES mitarbeiter (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE attendence');
    }
}
