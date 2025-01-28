<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250128081054 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cancion (id INT AUTO_INCREMENT NOT NULL, genero_id INT NOT NULL, titulo VARCHAR(255) NOT NULL, duracion INT NOT NULL, album VARCHAR(255) DEFAULT NULL, autor VARCHAR(255) NOT NULL, reproducciones INT NOT NULL, likes INT NOT NULL, INDEX IDX_E4620FA0BCE7B795 (genero_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE playlist (id INT AUTO_INCREMENT NOT NULL, propietario_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, visibilidad VARCHAR(255) NOT NULL, reproducciones INT NOT NULL, likes INT NOT NULL, INDEX IDX_D782112D53C8D32C (propietario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE playlist_cancion (id INT AUTO_INCREMENT NOT NULL, playlist_id INT NOT NULL, cancion_id INT DEFAULT NULL, INDEX IDX_5B5D18BA6BBD148 (playlist_id), INDEX IDX_5B5D18BA9B1D840F (cancion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, perfil_id INT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, nombre VARCHAR(255) NOT NULL, fecha_nacimiento DATE NOT NULL, UNIQUE INDEX UNIQ_2265B05D57291544 (perfil_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuario_playlist (id INT AUTO_INCREMENT NOT NULL, usuario_id INT DEFAULT NULL, playlist_id INT DEFAULT NULL, reproducida INT NOT NULL, INDEX IDX_3F43E3B4DB38439E (usuario_id), INDEX IDX_3F43E3B46BBD148 (playlist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cancion ADD CONSTRAINT FK_E4620FA0BCE7B795 FOREIGN KEY (genero_id) REFERENCES estilo (id)');
        $this->addSql('ALTER TABLE playlist ADD CONSTRAINT FK_D782112D53C8D32C FOREIGN KEY (propietario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE playlist_cancion ADD CONSTRAINT FK_5B5D18BA6BBD148 FOREIGN KEY (playlist_id) REFERENCES playlist (id)');
        $this->addSql('ALTER TABLE playlist_cancion ADD CONSTRAINT FK_5B5D18BA9B1D840F FOREIGN KEY (cancion_id) REFERENCES cancion (id)');
        $this->addSql('ALTER TABLE usuario ADD CONSTRAINT FK_2265B05D57291544 FOREIGN KEY (perfil_id) REFERENCES perfil (id)');
        $this->addSql('ALTER TABLE usuario_playlist ADD CONSTRAINT FK_3F43E3B4DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE usuario_playlist ADD CONSTRAINT FK_3F43E3B46BBD148 FOREIGN KEY (playlist_id) REFERENCES playlist (id)');
        $this->addSql('ALTER TABLE estilo ADD perfil_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE estilo ADD CONSTRAINT FK_E0973A5357291544 FOREIGN KEY (perfil_id) REFERENCES perfil (id)');
        $this->addSql('CREATE INDEX IDX_E0973A5357291544 ON estilo (perfil_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cancion DROP FOREIGN KEY FK_E4620FA0BCE7B795');
        $this->addSql('ALTER TABLE playlist DROP FOREIGN KEY FK_D782112D53C8D32C');
        $this->addSql('ALTER TABLE playlist_cancion DROP FOREIGN KEY FK_5B5D18BA6BBD148');
        $this->addSql('ALTER TABLE playlist_cancion DROP FOREIGN KEY FK_5B5D18BA9B1D840F');
        $this->addSql('ALTER TABLE usuario DROP FOREIGN KEY FK_2265B05D57291544');
        $this->addSql('ALTER TABLE usuario_playlist DROP FOREIGN KEY FK_3F43E3B4DB38439E');
        $this->addSql('ALTER TABLE usuario_playlist DROP FOREIGN KEY FK_3F43E3B46BBD148');
        $this->addSql('DROP TABLE cancion');
        $this->addSql('DROP TABLE playlist');
        $this->addSql('DROP TABLE playlist_cancion');
        $this->addSql('DROP TABLE usuario');
        $this->addSql('DROP TABLE usuario_playlist');
        $this->addSql('ALTER TABLE estilo DROP FOREIGN KEY FK_E0973A5357291544');
        $this->addSql('DROP INDEX IDX_E0973A5357291544 ON estilo');
        $this->addSql('ALTER TABLE estilo DROP perfil_id');
    }
}
