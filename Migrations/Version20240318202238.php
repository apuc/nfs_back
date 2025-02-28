<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240318202238 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_package_product (product_package_id INT NOT NULL, product_id INT NOT NULL, PRIMARY KEY(product_package_id, product_id))');
        $this->addSql('CREATE INDEX IDX_6E9A64BC672BF4D4 ON product_package_product (product_package_id)');
        $this->addSql('CREATE INDEX IDX_6E9A64BC4584665A ON product_package_product (product_id)');
        $this->addSql('ALTER TABLE product_package_product ADD CONSTRAINT FK_6E9A64BC672BF4D4 FOREIGN KEY (product_package_id) REFERENCES product_package (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product_package_product ADD CONSTRAINT FK_6E9A64BC4584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE product_package_product DROP CONSTRAINT FK_6E9A64BC672BF4D4');
        $this->addSql('ALTER TABLE product_package_product DROP CONSTRAINT FK_6E9A64BC4584665A');
        $this->addSql('DROP TABLE product_package_product');
    }
}
