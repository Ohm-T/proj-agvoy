<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211013153109 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, familyname VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
        $this->addSql('DROP TABLE client_mngmt');
        $this->addSql('DROP INDEX UNIQ_9474526CB83297E7');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, reservation_id, content FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, reservation_id INTEGER NOT NULL, content CLOB DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_9474526CB83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO comment (id, reservation_id, content) SELECT id, reservation_id, content FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9474526CB83297E7 ON comment (reservation_id)');
        $this->addSql('DROP INDEX IDX_AB3946AC54177093');
        $this->addSql('DROP INDEX IDX_AB3946AC98260155');
        $this->addSql('CREATE TEMPORARY TABLE __temp__region_room AS SELECT region_id, room_id FROM region_room');
        $this->addSql('DROP TABLE region_room');
        $this->addSql('CREATE TABLE region_room (region_id INTEGER NOT NULL, room_id INTEGER NOT NULL, PRIMARY KEY(region_id, room_id), CONSTRAINT FK_AB3946AC98260155 FOREIGN KEY (region_id) REFERENCES region (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_AB3946AC54177093 FOREIGN KEY (room_id) REFERENCES room (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO region_room (region_id, room_id) SELECT region_id, room_id FROM __temp__region_room');
        $this->addSql('DROP TABLE __temp__region_room');
        $this->addSql('CREATE INDEX IDX_AB3946AC54177093 ON region_room (room_id)');
        $this->addSql('CREATE INDEX IDX_AB3946AC98260155 ON region_room (region_id)');
        $this->addSql('DROP INDEX IDX_42C8495554177093');
        $this->addSql('DROP INDEX IDX_42C8495519EB6921');
        $this->addSql('CREATE TEMPORARY TABLE __temp__reservation AS SELECT id, client_id, room_id, paid, datedeb, datefin FROM reservation');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('CREATE TABLE reservation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, client_id INTEGER DEFAULT NULL, room_id INTEGER NOT NULL, paid BOOLEAN NOT NULL, datedeb DATE NOT NULL, datefin DATE NOT NULL, CONSTRAINT FK_42C8495519EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_42C8495554177093 FOREIGN KEY (room_id) REFERENCES room (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO reservation (id, client_id, room_id, paid, datedeb, datefin) SELECT id, client_id, room_id, paid, datedeb, datefin FROM __temp__reservation');
        $this->addSql('DROP TABLE __temp__reservation');
        $this->addSql('CREATE INDEX IDX_42C8495554177093 ON reservation (room_id)');
        $this->addSql('CREATE INDEX IDX_42C8495519EB6921 ON reservation (client_id)');
        $this->addSql('DROP INDEX IDX_729F519B54177093');
        $this->addSql('CREATE TEMPORARY TABLE __temp__room AS SELECT id, room_id, summary, description, capacity, superficy, price, address FROM room');
        $this->addSql('DROP TABLE room');
        $this->addSql('CREATE TABLE room (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, room_id INTEGER DEFAULT NULL, summary VARCHAR(255) DEFAULT NULL COLLATE BINARY, description CLOB NOT NULL COLLATE BINARY, capacity INTEGER NOT NULL, superficy DOUBLE PRECISION NOT NULL, price DOUBLE PRECISION NOT NULL, address CLOB NOT NULL COLLATE BINARY, CONSTRAINT FK_729F519B54177093 FOREIGN KEY (room_id) REFERENCES owner (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO room (id, room_id, summary, description, capacity, superficy, price, address) SELECT id, room_id, summary, description, capacity, superficy, price, address FROM __temp__room');
        $this->addSql('DROP TABLE __temp__room');
        $this->addSql('CREATE INDEX IDX_729F519B54177093 ON room (room_id)');
        $this->addSql('DROP INDEX IDX_B9D87FBB54177093');
        $this->addSql('CREATE TEMPORARY TABLE __temp__unavailable_period AS SELECT id, room_id, datedeb, datefin FROM unavailable_period');
        $this->addSql('DROP TABLE unavailable_period');
        $this->addSql('CREATE TABLE unavailable_period (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, room_id INTEGER NOT NULL, datedeb DATE DEFAULT NULL, datefin DATE DEFAULT NULL, CONSTRAINT FK_B9D87FBB54177093 FOREIGN KEY (room_id) REFERENCES room (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO unavailable_period (id, room_id, datedeb, datefin) SELECT id, room_id, datedeb, datefin FROM __temp__unavailable_period');
        $this->addSql('DROP TABLE __temp__unavailable_period');
        $this->addSql('CREATE INDEX IDX_B9D87FBB54177093 ON unavailable_period (room_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client_mngmt (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL COLLATE BINARY, familyname VARCHAR(255) NOT NULL COLLATE BINARY)');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP INDEX UNIQ_9474526CB83297E7');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, reservation_id, content FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, reservation_id INTEGER NOT NULL, content CLOB DEFAULT NULL)');
        $this->addSql('INSERT INTO comment (id, reservation_id, content) SELECT id, reservation_id, content FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9474526CB83297E7 ON comment (reservation_id)');
        $this->addSql('DROP INDEX IDX_AB3946AC98260155');
        $this->addSql('DROP INDEX IDX_AB3946AC54177093');
        $this->addSql('CREATE TEMPORARY TABLE __temp__region_room AS SELECT region_id, room_id FROM region_room');
        $this->addSql('DROP TABLE region_room');
        $this->addSql('CREATE TABLE region_room (region_id INTEGER NOT NULL, room_id INTEGER NOT NULL, PRIMARY KEY(region_id, room_id))');
        $this->addSql('INSERT INTO region_room (region_id, room_id) SELECT region_id, room_id FROM __temp__region_room');
        $this->addSql('DROP TABLE __temp__region_room');
        $this->addSql('CREATE INDEX IDX_AB3946AC98260155 ON region_room (region_id)');
        $this->addSql('CREATE INDEX IDX_AB3946AC54177093 ON region_room (room_id)');
        $this->addSql('DROP INDEX IDX_42C8495519EB6921');
        $this->addSql('DROP INDEX IDX_42C8495554177093');
        $this->addSql('CREATE TEMPORARY TABLE __temp__reservation AS SELECT id, client_id, room_id, paid, datedeb, datefin FROM reservation');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('CREATE TABLE reservation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, client_id INTEGER DEFAULT NULL, room_id INTEGER NOT NULL, paid BOOLEAN NOT NULL, datedeb DATE NOT NULL, datefin DATE NOT NULL, CONSTRAINT FK_42C8495519EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO reservation (id, client_id, room_id, paid, datedeb, datefin) SELECT id, client_id, room_id, paid, datedeb, datefin FROM __temp__reservation');
        $this->addSql('DROP TABLE __temp__reservation');
        $this->addSql('CREATE INDEX IDX_42C8495519EB6921 ON reservation (client_id)');
        $this->addSql('CREATE INDEX IDX_42C8495554177093 ON reservation (room_id)');
        $this->addSql('DROP INDEX IDX_729F519B54177093');
        $this->addSql('CREATE TEMPORARY TABLE __temp__room AS SELECT id, room_id, summary, description, capacity, superficy, price, address FROM room');
        $this->addSql('DROP TABLE room');
        $this->addSql('CREATE TABLE room (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, room_id INTEGER DEFAULT NULL, summary VARCHAR(255) DEFAULT NULL, description CLOB NOT NULL, capacity INTEGER NOT NULL, superficy DOUBLE PRECISION NOT NULL, price DOUBLE PRECISION NOT NULL, address CLOB NOT NULL)');
        $this->addSql('INSERT INTO room (id, room_id, summary, description, capacity, superficy, price, address) SELECT id, room_id, summary, description, capacity, superficy, price, address FROM __temp__room');
        $this->addSql('DROP TABLE __temp__room');
        $this->addSql('CREATE INDEX IDX_729F519B54177093 ON room (room_id)');
        $this->addSql('DROP INDEX IDX_B9D87FBB54177093');
        $this->addSql('CREATE TEMPORARY TABLE __temp__unavailable_period AS SELECT id, room_id, datedeb, datefin FROM unavailable_period');
        $this->addSql('DROP TABLE unavailable_period');
        $this->addSql('CREATE TABLE unavailable_period (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, room_id INTEGER NOT NULL, datedeb DATE DEFAULT NULL, datefin DATE DEFAULT NULL)');
        $this->addSql('INSERT INTO unavailable_period (id, room_id, datedeb, datefin) SELECT id, room_id, datedeb, datefin FROM __temp__unavailable_period');
        $this->addSql('DROP TABLE __temp__unavailable_period');
        $this->addSql('CREATE INDEX IDX_B9D87FBB54177093 ON unavailable_period (room_id)');
    }
}
