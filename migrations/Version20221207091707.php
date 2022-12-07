<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221207091707 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE candidacy (id INT AUTO_INCREMENT NOT NULL, student_id INT NOT NULL, internship_id INT DEFAULT NULL, cv LONGBLOB NOT NULL, cover_letter LONGTEXT NOT NULL, INDEX IDX_D930569DCB944F1A (student_id), INDEX IDX_D930569D7A4A70BE (internship_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE candidacy ADD CONSTRAINT FK_D930569DCB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE candidacy ADD CONSTRAINT FK_D930569D7A4A70BE FOREIGN KEY (internship_id) REFERENCES internship (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidacy DROP FOREIGN KEY FK_D930569DCB944F1A');
        $this->addSql('ALTER TABLE candidacy DROP FOREIGN KEY FK_D930569D7A4A70BE');
        $this->addSql('DROP TABLE candidacy');
    }
}
