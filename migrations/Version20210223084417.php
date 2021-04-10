<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210223084417 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attendence ADD status_id INT DEFAULT NULL, DROP status');
        $this->addSql('ALTER TABLE attendence ADD CONSTRAINT FK_E2819AC66BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E2819AC66BF700BD ON attendence (status_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attendence DROP FOREIGN KEY FK_E2819AC66BF700BD');
        $this->addSql('DROP INDEX UNIQ_E2819AC66BF700BD ON attendence');
        $this->addSql('ALTER TABLE attendence ADD status VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP status_id');
    }
}
