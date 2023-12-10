<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231210123507 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_package ADD status INT DEFAULT 1 NOT NULL');
        $this->addSql('ALTER TABLE product_package ADD hash VARCHAR(60)');
        $this->addSql('COMMENT ON COLUMN product_package.status IS \'Статус пакета услуг\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_package DROP status');
        $this->addSql('ALTER TABLE product_package DROP hash');
    }
}
