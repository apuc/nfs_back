<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231204093849 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE partner (id SERIAL NOT NULL, name VARCHAR(200) NOT NULL, details JSONB DEFAULT NULL, contacts JSONB DEFAULT NULL, occupation VARCHAR(100) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON TABLE partner IS \'Справочник ТСП\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE partner');
    }
}
