<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231210051733 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product ADD status INT DEFAULT 1 NOT NULL');
        $this->addSql('COMMENT ON COLUMN product.status IS \'Статус услуги\'');
        $this->addSql('CREATE INDEX product_status_idx ON product (status)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX product_status_idx');
        $this->addSql('ALTER TABLE product DROP status');
    }
}
