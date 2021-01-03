<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201221132805 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE timesheet (id INT AUTO_INCREMENT NOT NULL, atendance_id_id INT NOT NULL, check_in VARCHAR(50) DEFAULT NULL, check_out VARCHAR(50) DEFAULT NULL, INDEX IDX_77A4E8D484B7B059 (atendance_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE timesheet ADD CONSTRAINT FK_77A4E8D484B7B059 FOREIGN KEY (atendance_id_id) REFERENCES attendence (id)');
        $this->addSql('ALTER TABLE attendence CHANGE date date VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE timesheet');
        $this->addSql('ALTER TABLE attendence CHANGE date date VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
