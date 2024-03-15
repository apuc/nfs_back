<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240228211203 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE project (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, status INT DEFAULT 1 NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX project_status_idx ON project (status)');
        $this->addSql('COMMENT ON TABLE project IS \'Справочник Проектов\'');
        $this->addSql('COMMENT ON COLUMN project.status IS \'Статус проекта\'');
        $this->addSql('ALTER TABLE certificate ALTER client_order_id DROP NOT NULL');
        $this->addSql('ALTER TABLE certificate ALTER product_package_id DROP NOT NULL');
        $this->addSql('ALTER TABLE certificate ADD CONSTRAINT FK_219CDA4AA3795DFD FOREIGN KEY (client_order_id) REFERENCES client_order (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE certificate ADD CONSTRAINT FK_219CDA4A672BF4D4 FOREIGN KEY (product_package_id) REFERENCES product_package (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP INDEX city_title_idx');
        $this->addSql('DROP INDEX region_title_idx');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE project');
        $this->addSql('CREATE INDEX city_title_idx ON city (title)');
        $this->addSql('ALTER TABLE certificate DROP CONSTRAINT FK_219CDA4AA3795DFD');
        $this->addSql('ALTER TABLE certificate DROP CONSTRAINT FK_219CDA4A672BF4D4');
        $this->addSql('ALTER TABLE certificate ALTER client_order_id SET NOT NULL');
        $this->addSql('ALTER TABLE certificate ALTER product_package_id SET NOT NULL');
        $this->addSql('CREATE INDEX region_title_idx ON region (title)');
    }
}
