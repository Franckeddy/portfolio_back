<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191229215901 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE company_activity_area (company_id INT NOT NULL, activity_area_id INT NOT NULL, INDEX IDX_A872C487979B1AD6 (company_id), INDEX IDX_A872C487BD5D367C (activity_area_id), PRIMARY KEY(company_id, activity_area_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE company_activity_area ADD CONSTRAINT FK_A872C487979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE company_activity_area ADD CONSTRAINT FK_A872C487BD5D367C FOREIGN KEY (activity_area_id) REFERENCES activity_area (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE activities_area_company');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
        $this->addSql('ALTER TABLE user ADD username VARCHAR(180) NOT NULL, DROP email');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE activities_area_company (company_id INT NOT NULL, activity_area_id INT NOT NULL, INDEX IDX_8F729DF9979B1AD6 (company_id), INDEX IDX_8F729DF9BD5D367C (activity_area_id), PRIMARY KEY(company_id, activity_area_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE activities_area_company ADD CONSTRAINT FK_8F729DF9979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE activities_area_company ADD CONSTRAINT FK_8F729DF9BD5D367C FOREIGN KEY (activity_area_id) REFERENCES activity_area (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE company_activity_area');
        $this->addSql('DROP INDEX UNIQ_8D93D649F85E0677 ON user');
        $this->addSql('ALTER TABLE user ADD email VARCHAR(180) DEFAULT NULL COLLATE utf8mb4_unicode_ci, DROP username');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }
}
