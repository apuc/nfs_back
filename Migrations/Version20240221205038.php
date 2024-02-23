<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240221205038 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE order_id_seq CASCADE');
        $this->addSql('CREATE TABLE certificate (id SERIAL NOT NULL, client_order_id INT NOT NULL, product_package_id INT NOT NULL, hash VARCHAR(60) DEFAULT NULL, amount INT DEFAULT NULL, status INT DEFAULT 1 NOT NULL, card_number VARCHAR(255) DEFAULT NULL, payment_system VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX certificate_product_package_idx ON certificate (product_package_id)');
        $this->addSql('CREATE INDEX certificate_client_order_idx ON certificate (client_order_id)');
        $this->addSql('CREATE INDEX certificate_status_idx ON certificate (status)');
        $this->addSql('COMMENT ON TABLE certificate IS \'Справочник Сертификаты\'');
        $this->addSql('COMMENT ON COLUMN certificate.status IS \'Статус Сертификата\'');
        $this->addSql('DROP TABLE "order"');
        $this->addSql('COMMENT ON COLUMN client_order.status IS \'Статус заказа\'');
        $this->addSql('CREATE INDEX order_status_idx ON client_order (status)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE order_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "order" (id INT NOT NULL, status INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX order_status_idx ON "order" (status)');
        $this->addSql('COMMENT ON TABLE "order" IS \'Справочник Заказов\'');
        $this->addSql('DROP TABLE certificate');
        $this->addSql('DROP INDEX order_status_idx');
        $this->addSql('COMMENT ON COLUMN client_order.status IS NULL');
    }
}
