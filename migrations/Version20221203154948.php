<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221203154948 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE internship ADD company_id INT NOT NULL');
        $this->addSql('ALTER TABLE internship ADD CONSTRAINT FK_10D1B00C979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('CREATE INDEX IDX_10D1B00C979B1AD6 ON internship (company_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE internship DROP FOREIGN KEY FK_10D1B00C979B1AD6');
        $this->addSql('DROP INDEX IDX_10D1B00C979B1AD6 ON internship');
        $this->addSql('ALTER TABLE internship DROP company_id');
    }
}
