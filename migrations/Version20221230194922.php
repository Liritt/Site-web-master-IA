<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221230194922 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ter ADD selected_student_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ter ADD CONSTRAINT FK_A38966CFC140BF9 FOREIGN KEY (selected_student_id) REFERENCES student (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A38966CFC140BF9 ON ter (selected_student_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ter DROP FOREIGN KEY FK_A38966CFC140BF9');
        $this->addSql('DROP INDEX UNIQ_A38966CFC140BF9 ON ter');
        $this->addSql('ALTER TABLE ter DROP selected_student_id');
    }
}
