<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250924172316 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE depense ADD slug VARCHAR(255)');
        $this->addSql('UPDATE depense SET slug = id');
        $this->addSql('ALTER TABLE depense MODIFY slug VARCHAR(255) NOT NULL;');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_34059757989D9B62 ON depense (slug)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_34059757989D9B62 ON depense');
        $this->addSql('ALTER TABLE depense DROP slug');
    }
}
