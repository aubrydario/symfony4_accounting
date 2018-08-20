<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180717084146 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE abo ADD user_id INT DEFAULT NULL, ADD color VARCHAR(7) NOT NULL');
        $this->addSql('ALTER TABLE abo ADD CONSTRAINT FK_3C920DE9A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_3C920DE9A76ED395 ON abo (user_id)');
        $this->addSql('ALTER TABLE customer ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_81398E09A76ED395 ON customer (user_id)');
        $this->addSql('ALTER TABLE hour ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE hour ADD CONSTRAINT FK_701E114EA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_701E114EA76ED395 ON hour (user_id)');
        $this->addSql('ALTER TABLE payment ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_6D28840DA76ED395 ON payment (user_id)');
        $this->addSql('DROP INDEX UNIQ_8D93D649F85E0677 ON user');
        $this->addSql('ALTER TABLE user ADD username_canonical VARCHAR(180) NOT NULL, ADD email_canonical VARCHAR(180) NOT NULL, ADD enabled TINYINT(1) NOT NULL, ADD salt VARCHAR(255) DEFAULT NULL, ADD last_login DATETIME DEFAULT NULL, ADD confirmation_token VARCHAR(180) DEFAULT NULL, ADD password_requested_at DATETIME DEFAULT NULL, ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', DROP firstname, DROP surname, CHANGE username username VARCHAR(180) NOT NULL, CHANGE password password VARCHAR(255) NOT NULL, CHANGE email email VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64992FC23A8 ON user (username_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649A0D96FBF ON user (email_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649C05FB297 ON user (confirmation_token)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE abo DROP FOREIGN KEY FK_3C920DE9A76ED395');
        $this->addSql('DROP INDEX IDX_3C920DE9A76ED395 ON abo');
        $this->addSql('ALTER TABLE abo DROP user_id, DROP color');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09A76ED395');
        $this->addSql('DROP INDEX IDX_81398E09A76ED395 ON customer');
        $this->addSql('ALTER TABLE customer DROP user_id');
        $this->addSql('ALTER TABLE hour DROP FOREIGN KEY FK_701E114EA76ED395');
        $this->addSql('DROP INDEX IDX_701E114EA76ED395 ON hour');
        $this->addSql('ALTER TABLE hour DROP user_id');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DA76ED395');
        $this->addSql('DROP INDEX IDX_6D28840DA76ED395 ON payment');
        $this->addSql('ALTER TABLE payment DROP user_id');
        $this->addSql('DROP INDEX UNIQ_8D93D64992FC23A8 ON `user`');
        $this->addSql('DROP INDEX UNIQ_8D93D649A0D96FBF ON `user`');
        $this->addSql('DROP INDEX UNIQ_8D93D649C05FB297 ON `user`');
        $this->addSql('ALTER TABLE `user` ADD firstname VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, ADD surname VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, DROP username_canonical, DROP email_canonical, DROP enabled, DROP salt, DROP last_login, DROP confirmation_token, DROP password_requested_at, DROP roles, CHANGE username username VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE email email VARCHAR(100) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE password password VARCHAR(64) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON `user` (username)');
    }
}
