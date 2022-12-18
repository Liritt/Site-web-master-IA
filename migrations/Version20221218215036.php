<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221218215036 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidacy_ter DROP FOREIGN KEY FK_4001B86EC6580D52');
        $this->addSql('DROP INDEX IDX_4001B86EC6580D52 ON candidacy_ter');
        $this->addSql('ALTER TABLE candidacy_ter ADD ter_id INT DEFAULT NULL, CHANGE admis_id student_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE candidacy_ter ADD CONSTRAINT FK_4001B86ECB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE candidacy_ter ADD CONSTRAINT FK_4001B86E2895627C FOREIGN KEY (ter_id) REFERENCES ter (id)');
        $this->addSql('CREATE INDEX IDX_4001B86ECB944F1A ON candidacy_ter (student_id)');
        $this->addSql('CREATE INDEX IDX_4001B86E2895627C ON candidacy_ter (ter_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidacy_ter DROP FOREIGN KEY FK_4001B86ECB944F1A');
        $this->addSql('ALTER TABLE candidacy_ter DROP FOREIGN KEY FK_4001B86E2895627C');
        $this->addSql('DROP INDEX IDX_4001B86ECB944F1A ON candidacy_ter');
        $this->addSql('DROP INDEX IDX_4001B86E2895627C ON candidacy_ter');
        $this->addSql('ALTER TABLE candidacy_ter ADD admis_id INT DEFAULT NULL, DROP student_id, DROP ter_id');
        $this->addSql('ALTER TABLE candidacy_ter ADD CONSTRAINT FK_4001B86EC6580D52 FOREIGN KEY (admis_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_4001B86EC6580D52 ON candidacy_ter (admis_id)');
    }
}
