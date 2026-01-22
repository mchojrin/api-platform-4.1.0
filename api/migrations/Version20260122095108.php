<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260122095108 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assignment_request ADD client_id INT NOT NULL');
        $this->addSql('ALTER TABLE assignment_request ADD CONSTRAINT FK_58A9C26619EB6921 FOREIGN KEY (client_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_58A9C26619EB6921 ON assignment_request (client_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assignment_request DROP CONSTRAINT FK_58A9C26619EB6921');
        $this->addSql('DROP INDEX IDX_58A9C26619EB6921');
        $this->addSql('ALTER TABLE assignment_request DROP client_id');
    }
}
