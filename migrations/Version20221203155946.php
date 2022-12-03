<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221203155946 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE student ADD internship_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF337A4A70BE FOREIGN KEY (internship_id) REFERENCES internship (id)');
        $this->addSql('CREATE INDEX IDX_B723AF337A4A70BE ON student (internship_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF337A4A70BE');
        $this->addSql('DROP INDEX IDX_B723AF337A4A70BE ON student');
        $this->addSql('ALTER TABLE student DROP internship_id');
    }
}
