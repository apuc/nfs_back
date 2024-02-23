<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240220204337 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE order_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "order" (id INT NOT NULL, status INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX order_status_idx ON "order" (status)');
        $this->addSql('COMMENT ON TABLE "order" IS \'Справочник Заказов\'');
        $this->addSql('ALTER TABLE partner_terminal DROP CONSTRAINT FK_ECBA93FBE77B6CE8');
        $this->addSql('ALTER TABLE partner_terminal ADD CONSTRAINT FK_ECBA93FBE77B6CE8 FOREIGN KEY (terminal_id) REFERENCES terminal (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE order_id_seq CASCADE');
        $this->addSql('DROP TABLE "order"');
        $this->addSql('ALTER TABLE partner_terminal DROP CONSTRAINT fk_ecba93fbe77b6ce8');
        $this->addSql('ALTER TABLE partner_terminal ADD CONSTRAINT fk_ecba93fbe77b6ce8 FOREIGN KEY (terminal_id) REFERENCES partner (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
