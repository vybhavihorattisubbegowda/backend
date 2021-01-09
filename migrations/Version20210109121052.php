<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210109121052 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094F48E1E977');
        $this->addSql('DROP INDEX UNIQ_4FBF094F48E1E977 ON company');
        $this->addSql('ALTER TABLE company DROP address_id_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company ADD address_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094F48E1E977 FOREIGN KEY (address_id_id) REFERENCES address (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4FBF094F48E1E977 ON company (address_id_id)');
    }
}
