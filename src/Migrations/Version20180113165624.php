<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180113165624 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE transaction');
        $this->addSql('CREATE TABLE bill (id INT AUTO_INCREMENT NOT NULL, customer_id INT DEFAULT NULL, abo_id INT DEFAULT NULL, date DATE NOT NULL, INDEX IDX_7A2119E39395C3F3 (customer_id), INDEX IDX_7A2119E36BDDA206 (abo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bill ADD CONSTRAINT FK_7A2119E39395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE bill ADD CONSTRAINT FK_7A2119E36BDDA206 FOREIGN KEY (abo_id) REFERENCES abo (id)');
    }

    public function down(Schema $schema)
    {

    }
}
