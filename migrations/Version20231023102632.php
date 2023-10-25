<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231023102632 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chanel_user (chanel_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_5ED4DF1326F4971E (chanel_id), INDEX IDX_5ED4DF13A76ED395 (user_id), PRIMARY KEY(chanel_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE chanel_user ADD CONSTRAINT FK_5ED4DF1326F4971E FOREIGN KEY (chanel_id) REFERENCES chanel (id)');
        $this->addSql('ALTER TABLE chanel_user ADD CONSTRAINT FK_5ED4DF13A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE chanel DROP FOREIGN KEY FK_BBD2406A76ED395');
        $this->addSql('DROP INDEX IDX_BBD2406A76ED395 ON chanel');
        $this->addSql('ALTER TABLE chanel DROP user_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chanel_user DROP FOREIGN KEY FK_5ED4DF1326F4971E');
        $this->addSql('ALTER TABLE chanel_user DROP FOREIGN KEY FK_5ED4DF13A76ED395');
        $this->addSql('DROP TABLE chanel_user');
        $this->addSql('ALTER TABLE chanel ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE chanel ADD CONSTRAINT FK_BBD2406A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_BBD2406A76ED395 ON chanel (user_id)');
    }
}
