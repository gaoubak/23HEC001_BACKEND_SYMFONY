<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240106003417 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE follower ADD chanel_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE follower ADD CONSTRAINT FK_B9D6094626F4971E FOREIGN KEY (chanel_id) REFERENCES chanel (id)');
        $this->addSql('CREATE INDEX IDX_B9D6094626F4971E ON follower (chanel_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE follower DROP FOREIGN KEY FK_B9D6094626F4971E');
        $this->addSql('DROP INDEX IDX_B9D6094626F4971E ON follower');
        $this->addSql('ALTER TABLE follower DROP chanel_id');
    }
}
