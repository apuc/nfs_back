<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231205034630 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE partner (id SERIAL NOT NULL, name VARCHAR(200) NOT NULL, details JSONB DEFAULT NULL, contacts JSONB DEFAULT NULL, occupation VARCHAR(100) DEFAULT NULL, status INT DEFAULT 1 NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX partner_status_idx ON partner (status)');
        $this->addSql('COMMENT ON TABLE partner IS \'Справочник ТСП\'');
        $this->addSql('COMMENT ON COLUMN partner.details IS \'Реквизиты компании\'');
        $this->addSql('COMMENT ON COLUMN partner.contacts IS \'Контакты\'');
        $this->addSql('COMMENT ON COLUMN partner.occupation IS \'Направление деятельности\'');
        $this->addSql('COMMENT ON COLUMN partner.status IS \'Статус ТСП\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE partner');
    }
}
