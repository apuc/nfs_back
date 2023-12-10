<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231210044449 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product (id SERIAL NOT NULL, partner_id INT DEFAULT NULL, package_id INT DEFAULT NULL, title VARCHAR(200) NOT NULL, amount INT NOT NULL, description TEXT DEFAULT NULL, use_count INT NOT NULL, hash VARCHAR(60) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX product_partner_idx ON product (partner_id)');
        $this->addSql('CREATE INDEX product_package_idx ON product (package_id)');
        $this->addSql('COMMENT ON TABLE product IS \'Справочник услуг\'');
        $this->addSql('CREATE TABLE product_package (id SERIAL NOT NULL, title VARCHAR(200) NOT NULL, amount INT NOT NULL, finished_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, type INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON TABLE product_package IS \'Справочник пакетов услуг\'');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD9393F8FE FOREIGN KEY (partner_id) REFERENCES partner (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADF44CABFF FOREIGN KEY (package_id) REFERENCES product_package (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP CONSTRAINT FK_D34A04AD9393F8FE');
        $this->addSql('ALTER TABLE product DROP CONSTRAINT FK_D34A04ADF44CABFF');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_package');
    }
}
