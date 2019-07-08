<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190703180553 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Products DROP FOREIGN KEY FK_4ACC380C12469DE2');
        $this->addSql('DROP INDEX IDX_4ACC380C12469DE2 ON Products');
        $this->addSql('ALTER TABLE Products CHANGE category_id catalogs_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Products ADD CONSTRAINT FK_4ACC380C53B63F74 FOREIGN KEY (catalogs_id) REFERENCES catalogs (id)');
        $this->addSql('CREATE INDEX IDX_4ACC380C53B63F74 ON Products (catalogs_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Products DROP FOREIGN KEY FK_4ACC380C53B63F74');
        $this->addSql('DROP INDEX IDX_4ACC380C53B63F74 ON Products');
        $this->addSql('ALTER TABLE Products CHANGE catalogs_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Products ADD CONSTRAINT FK_4ACC380C12469DE2 FOREIGN KEY (category_id) REFERENCES catalogs (id)');
        $this->addSql('CREATE INDEX IDX_4ACC380C12469DE2 ON Products (category_id)');
    }
}
