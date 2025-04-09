<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250405101624 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE family ADD main_member_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE family ADD CONSTRAINT FK_A5E6215B5521745C FOREIGN KEY (main_member_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_A5E6215B5521745C ON family (main_member_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE family DROP FOREIGN KEY FK_A5E6215B5521745C
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX UNIQ_A5E6215B5521745C ON family
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE family DROP main_member_id
        SQL);
    }
}
