<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221217220953 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE candidacy_ter (id INT AUTO_INCREMENT NOT NULL, admis_id INT DEFAULT NULL, date DATETIME NOT NULL, INDEX IDX_4001B86EC6580D52 (admis_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE candidacy_ter ADD CONSTRAINT FK_4001B86EC6580D52 FOREIGN KEY (admis_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidacy_ter DROP FOREIGN KEY FK_4001B86EC6580D52');
        $this->addSql('DROP TABLE candidacy_ter');
    }
}
