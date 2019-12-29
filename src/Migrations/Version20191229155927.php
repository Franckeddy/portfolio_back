<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191229155927 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE company_activity_area (company_id INT NOT NULL, activity_area_id INT NOT NULL, INDEX IDX_A872C487979B1AD6 (company_id), INDEX IDX_A872C487BD5D367C (activity_area_id), PRIMARY KEY(company_id, activity_area_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE company_activity_area ADD CONSTRAINT FK_A872C487979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE company_activity_area ADD CONSTRAINT FK_A872C487BD5D367C FOREIGN KEY (activity_area_id) REFERENCES activity_area (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE company CHANGE name name VARCHAR(255) DEFAULT NULL, CHANGE start_date start_date DATE DEFAULT NULL, CHANGE end_date end_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE diplome CHANGE date_obtention date_obtention DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE school CHANGE name name VARCHAR(255) DEFAULT NULL, CHANGE start_date start_date DATE DEFAULT NULL, CHANGE end_date end_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE formation_school DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE formation_school ADD PRIMARY KEY (school_id, formation_id)');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
        $this->addSql('ALTER TABLE user CHANGE email username VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
        $this->addSql('ALTER TABLE license CHANGE name name VARCHAR(255) DEFAULT NULL, CHANGE date_obtention date_obtention DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE langue CHANGE name name VARCHAR(255) DEFAULT NULL, CHANGE level level VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE candidat CHANGE date_of_birth date_of_birth DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE langue_candidat DROP INDEX IDX_73D206EC2AADBACD, ADD UNIQUE INDEX UNIQ_73D206EC2AADBACD (langue_id)');
        $this->addSql('ALTER TABLE langue_candidat DROP FOREIGN KEY FK_73D206EC2AADBACD');
        $this->addSql('ALTER TABLE langue_candidat DROP FOREIGN KEY FK_73D206EC8D0EB82');
        $this->addSql('ALTER TABLE langue_candidat DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE langue_candidat ADD CONSTRAINT FK_73D206EC2AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id)');
        $this->addSql('ALTER TABLE langue_candidat ADD CONSTRAINT FK_73D206EC8D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id)');
        $this->addSql('ALTER TABLE langue_candidat ADD PRIMARY KEY (candidat_id, langue_id)');
        $this->addSql('ALTER TABLE license_candidat DROP INDEX IDX_96E52546460F904B, ADD UNIQUE INDEX UNIQ_96E52546460F904B (license_id)');
        $this->addSql('ALTER TABLE license_candidat DROP FOREIGN KEY FK_96E52546460F904B');
        $this->addSql('ALTER TABLE license_candidat DROP FOREIGN KEY FK_96E525468D0EB82');
        $this->addSql('ALTER TABLE license_candidat DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE license_candidat ADD CONSTRAINT FK_96E52546460F904B FOREIGN KEY (license_id) REFERENCES license (id)');
        $this->addSql('ALTER TABLE license_candidat ADD CONSTRAINT FK_96E525468D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id)');
        $this->addSql('ALTER TABLE license_candidat ADD PRIMARY KEY (candidat_id, license_id)');
        $this->addSql('ALTER TABLE school_candidat DROP INDEX IDX_94F38035C32A47EE, ADD UNIQUE INDEX UNIQ_94F38035C32A47EE (school_id)');
        $this->addSql('ALTER TABLE school_candidat DROP FOREIGN KEY FK_94F380358D0EB82');
        $this->addSql('ALTER TABLE school_candidat DROP FOREIGN KEY FK_94F38035C32A47EE');
        $this->addSql('ALTER TABLE school_candidat DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE school_candidat ADD CONSTRAINT FK_94F380358D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id)');
        $this->addSql('ALTER TABLE school_candidat ADD CONSTRAINT FK_94F38035C32A47EE FOREIGN KEY (school_id) REFERENCES school (id)');
        $this->addSql('ALTER TABLE school_candidat ADD PRIMARY KEY (candidat_id, school_id)');
        $this->addSql('ALTER TABLE company_candidat DROP INDEX IDX_7222A11C979B1AD6, ADD UNIQUE INDEX UNIQ_7222A11C979B1AD6 (company_id)');
        $this->addSql('ALTER TABLE company_candidat DROP FOREIGN KEY FK_7222A11C8D0EB82');
        $this->addSql('ALTER TABLE company_candidat DROP FOREIGN KEY FK_7222A11C979B1AD6');
        $this->addSql('ALTER TABLE company_candidat DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE company_candidat ADD CONSTRAINT FK_7222A11C8D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id)');
        $this->addSql('ALTER TABLE company_candidat ADD CONSTRAINT FK_7222A11C979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE company_candidat ADD PRIMARY KEY (candidat_id, company_id)');
        $this->addSql('ALTER TABLE activity_area CHANGE name name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE formation CHANGE name name VARCHAR(255) DEFAULT NULL, CHANGE start_date start_date DATE DEFAULT NULL, CHANGE end_date end_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE diplome_formation DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE diplome_formation ADD PRIMARY KEY (formation_id, diplome_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE company_activity_area');
        $this->addSql('ALTER TABLE activity_area CHANGE name name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE candidat CHANGE date_of_birth date_of_birth DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE company CHANGE name name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE start_date start_date DATE NOT NULL, CHANGE end_date end_date DATE NOT NULL');
        $this->addSql('ALTER TABLE company_candidat DROP INDEX UNIQ_7222A11C979B1AD6, ADD INDEX IDX_7222A11C979B1AD6 (company_id)');
        $this->addSql('ALTER TABLE company_candidat DROP FOREIGN KEY FK_7222A11C8D0EB82');
        $this->addSql('ALTER TABLE company_candidat DROP FOREIGN KEY FK_7222A11C979B1AD6');
        $this->addSql('ALTER TABLE company_candidat DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE company_candidat ADD CONSTRAINT FK_7222A11C8D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE company_candidat ADD CONSTRAINT FK_7222A11C979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE company_candidat ADD PRIMARY KEY (company_id, candidat_id)');
        $this->addSql('ALTER TABLE diplome CHANGE date_obtention date_obtention DATE NOT NULL');
        $this->addSql('ALTER TABLE diplome_formation DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE diplome_formation ADD PRIMARY KEY (diplome_id, formation_id)');
        $this->addSql('ALTER TABLE formation CHANGE name name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE start_date start_date DATE NOT NULL, CHANGE end_date end_date DATE NOT NULL');
        $this->addSql('ALTER TABLE formation_school DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE formation_school ADD PRIMARY KEY (formation_id, school_id)');
        $this->addSql('ALTER TABLE langue CHANGE name name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE level level VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE langue_candidat DROP INDEX UNIQ_73D206EC2AADBACD, ADD INDEX IDX_73D206EC2AADBACD (langue_id)');
        $this->addSql('ALTER TABLE langue_candidat DROP FOREIGN KEY FK_73D206EC8D0EB82');
        $this->addSql('ALTER TABLE langue_candidat DROP FOREIGN KEY FK_73D206EC2AADBACD');
        $this->addSql('ALTER TABLE langue_candidat DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE langue_candidat ADD CONSTRAINT FK_73D206EC8D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE langue_candidat ADD CONSTRAINT FK_73D206EC2AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE langue_candidat ADD PRIMARY KEY (langue_id, candidat_id)');
        $this->addSql('ALTER TABLE license CHANGE name name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE date_obtention date_obtention VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE license_candidat DROP INDEX UNIQ_96E52546460F904B, ADD INDEX IDX_96E52546460F904B (license_id)');
        $this->addSql('ALTER TABLE license_candidat DROP FOREIGN KEY FK_96E525468D0EB82');
        $this->addSql('ALTER TABLE license_candidat DROP FOREIGN KEY FK_96E52546460F904B');
        $this->addSql('ALTER TABLE license_candidat DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE license_candidat ADD CONSTRAINT FK_96E525468D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE license_candidat ADD CONSTRAINT FK_96E52546460F904B FOREIGN KEY (license_id) REFERENCES license (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE license_candidat ADD PRIMARY KEY (license_id, candidat_id)');
        $this->addSql('ALTER TABLE school CHANGE name name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE start_date start_date DATE NOT NULL, CHANGE end_date end_date DATE NOT NULL');
        $this->addSql('ALTER TABLE school_candidat DROP INDEX UNIQ_94F38035C32A47EE, ADD INDEX IDX_94F38035C32A47EE (school_id)');
        $this->addSql('ALTER TABLE school_candidat DROP FOREIGN KEY FK_94F380358D0EB82');
        $this->addSql('ALTER TABLE school_candidat DROP FOREIGN KEY FK_94F38035C32A47EE');
        $this->addSql('ALTER TABLE school_candidat DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE school_candidat ADD CONSTRAINT FK_94F380358D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE school_candidat ADD CONSTRAINT FK_94F38035C32A47EE FOREIGN KEY (school_id) REFERENCES school (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE school_candidat ADD PRIMARY KEY (school_id, candidat_id)');
        $this->addSql('DROP INDEX UNIQ_8D93D649F85E0677 ON user');
        $this->addSql('ALTER TABLE user CHANGE username email VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }
}
