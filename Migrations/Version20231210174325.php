<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231210174325 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE partner_terminal (id SERIAL NOT NULL, partner_id INT DEFAULT NULL, terminal_id INT DEFAULT NULL, product_package_id INT DEFAULT NULL, transferred_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, returned_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, cost INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX partner_link_idx ON partner_terminal (partner_id)');
        $this->addSql('CREATE INDEX terminal_link_idx ON partner_terminal (terminal_id)');
        $this->addSql('CREATE INDEX product_package_link_idx ON partner_terminal (product_package_id)');
        $this->addSql('ALTER TABLE partner_terminal ADD CONSTRAINT FK_ECBA93FB9393F8FE FOREIGN KEY (partner_id) REFERENCES partner (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE partner_terminal ADD CONSTRAINT FK_ECBA93FBE77B6CE8 FOREIGN KEY (terminal_id) REFERENCES partner (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE partner_terminal ADD CONSTRAINT FK_ECBA93FB672BF4D4 FOREIGN KEY (product_package_id) REFERENCES product_package (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partner_terminal DROP CONSTRAINT FK_ECBA93FB9393F8FE');
        $this->addSql('ALTER TABLE partner_terminal DROP CONSTRAINT FK_ECBA93FBE77B6CE8');
        $this->addSql('ALTER TABLE partner_terminal DROP CONSTRAINT FK_ECBA93FB672BF4D4');
        $this->addSql('DROP TABLE partner_terminal');
    }
}
