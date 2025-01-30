<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250130085219 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE estilo_cancion (estilo_id INT NOT NULL, cancion_id INT NOT NULL, INDEX IDX_6F2701C043798DA7 (estilo_id), INDEX IDX_6F2701C09B1D840F (cancion_id), PRIMARY KEY(estilo_id, cancion_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE estilo_cancion ADD CONSTRAINT FK_6F2701C043798DA7 FOREIGN KEY (estilo_id) REFERENCES estilo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE estilo_cancion ADD CONSTRAINT FK_6F2701C09B1D840F FOREIGN KEY (cancion_id) REFERENCES cancion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cancion DROP FOREIGN KEY FK_E4620FA0BCE7B795');
        $this->addSql('DROP INDEX IDX_E4620FA0BCE7B795 ON cancion');
        $this->addSql('ALTER TABLE cancion DROP genero_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE estilo_cancion DROP FOREIGN KEY FK_6F2701C043798DA7');
        $this->addSql('ALTER TABLE estilo_cancion DROP FOREIGN KEY FK_6F2701C09B1D840F');
        $this->addSql('DROP TABLE estilo_cancion');
        $this->addSql('ALTER TABLE cancion ADD genero_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cancion ADD CONSTRAINT FK_E4620FA0BCE7B795 FOREIGN KEY (genero_id) REFERENCES estilo (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_E4620FA0BCE7B795 ON cancion (genero_id)');
    }
}
