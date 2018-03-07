<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180307194949 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE hour (id INT AUTO_INCREMENT NOT NULL, time TIME NOT NULL, day INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE attendance ADD hour_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE attendance ADD CONSTRAINT FK_6DE30D91B5937BF9 FOREIGN KEY (hour_id) REFERENCES hour (id)');
        $this->addSql('CREATE INDEX IDX_6DE30D91B5937BF9 ON attendance (hour_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE attendance DROP FOREIGN KEY FK_6DE30D91B5937BF9');
        $this->addSql('DROP TABLE hour');
        $this->addSql('DROP INDEX IDX_6DE30D91B5937BF9 ON attendance');
        $this->addSql('ALTER TABLE attendance DROP hour_id');
    }
}
