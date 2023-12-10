<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231210135918 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE terminal (id SERIAL NOT NULL, title VARCHAR(200) NOT NULL, serial VARCHAR(200) NOT NULL, model_name VARCHAR(200) NOT NULL, sim_card_number VARCHAR(200) NOT NULL, mcam_card_number VARCHAR(200) NOT NULL, status INT DEFAULT 1 NOT NULL, hash VARCHAR(60) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON TABLE terminal IS \'Справочник терминалов\'');
        $this->addSql('ALTER TABLE product_package ALTER hash SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE terminal');
        $this->addSql('ALTER TABLE product_package ALTER hash DROP NOT NULL');
    }
}
