<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231209182505 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE city (id SERIAL NOT NULL, region_id INT DEFAULT NULL, title VARCHAR(200) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX city_title_idx ON city (title)');
        $this->addSql('CREATE INDEX city_region_idx ON city (region_id)');
        $this->addSql('COMMENT ON TABLE city IS \'Справочник городов\'');
        $this->addSql('CREATE TABLE partner (id SERIAL NOT NULL, city_id INT DEFAULT NULL, title VARCHAR(200) NOT NULL, details JSONB DEFAULT NULL, contacts JSONB DEFAULT NULL, occupation VARCHAR(100) DEFAULT NULL, status INT DEFAULT 1 NOT NULL, hash VARCHAR(60) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_312B3E168BAC62AF ON partner (city_id)');
        $this->addSql('CREATE INDEX partner_status_idx ON partner (status)');
        $this->addSql('COMMENT ON TABLE partner IS \'Справочник ТСП\'');
        $this->addSql('COMMENT ON COLUMN partner.details IS \'Реквизиты компании\'');
        $this->addSql('COMMENT ON COLUMN partner.contacts IS \'Контакты\'');
        $this->addSql('COMMENT ON COLUMN partner.occupation IS \'Направление деятельности\'');
        $this->addSql('COMMENT ON COLUMN partner.status IS \'Статус ТСП\'');
        $this->addSql('CREATE TABLE region (id SERIAL NOT NULL, title VARCHAR(200) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX region_title_idx ON region (title)');
        $this->addSql('COMMENT ON TABLE region IS \'Справочник регионов\'');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B023498260155 FOREIGN KEY (region_id) REFERENCES region (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE partner ADD CONSTRAINT FK_312B3E168BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE city DROP CONSTRAINT FK_2D5B023498260155');
        $this->addSql('ALTER TABLE partner DROP CONSTRAINT FK_312B3E168BAC62AF');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE partner');
        $this->addSql('DROP TABLE region');
    }
}
