<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190213214723 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE plane_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE city_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE airplane_user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE flight_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE luggage_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE company_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE airport_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE passenger_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE personal_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE plane (id INT NOT NULL, company_id INT NOT NULL, number INT NOT NULL, model VARCHAR(255) NOT NULL, seat_number INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C1B32D80979B1AD6 ON plane (company_id)');
        $this->addSql('CREATE TABLE city (id INT NOT NULL, name VARCHAR(255) NOT NULL, zip_code VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE airplane_user (id INT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE flight (id INT NOT NULL, departure_airport_id INT NOT NULL, arrival_airport_id INT NOT NULL, plane_id INT NOT NULL, number INT NOT NULL, departure_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, arrival_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C257E60EF631AB5C ON flight (departure_airport_id)');
        $this->addSql('CREATE INDEX IDX_C257E60E7F43E343 ON flight (arrival_airport_id)');
        $this->addSql('CREATE INDEX IDX_C257E60EF53666A8 ON flight (plane_id)');
        $this->addSql('CREATE TABLE flight_passenger (flight_id INT NOT NULL, passenger_id INT NOT NULL, PRIMARY KEY(flight_id, passenger_id))');
        $this->addSql('CREATE INDEX IDX_25F7F56F91F478C5 ON flight_passenger (flight_id)');
        $this->addSql('CREATE INDEX IDX_25F7F56F4502E565 ON flight_passenger (passenger_id)');
        $this->addSql('CREATE TABLE flight_personal (flight_id INT NOT NULL, personal_id INT NOT NULL, PRIMARY KEY(flight_id, personal_id))');
        $this->addSql('CREATE INDEX IDX_E865B71691F478C5 ON flight_personal (flight_id)');
        $this->addSql('CREATE INDEX IDX_E865B7165D430949 ON flight_personal (personal_id)');
        $this->addSql('CREATE TABLE luggage (id INT NOT NULL, passenger_id INT DEFAULT NULL, weight INT NOT NULL, height INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5907C8DA4502E565 ON luggage (passenger_id)');
        $this->addSql('CREATE TABLE company (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE airport (id INT NOT NULL, city_id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7E91F7C28BAC62AF ON airport (city_id)');
        $this->addSql('CREATE TABLE passenger (id INT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, birthdate TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, gender BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE personal (id INT NOT NULL, company_id INT NOT NULL, name VARCHAR(255) NOT NULL, function VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F18A6D84979B1AD6 ON personal (company_id)');
        $this->addSql('ALTER TABLE plane ADD CONSTRAINT FK_C1B32D80979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE flight ADD CONSTRAINT FK_C257E60EF631AB5C FOREIGN KEY (departure_airport_id) REFERENCES airport (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE flight ADD CONSTRAINT FK_C257E60E7F43E343 FOREIGN KEY (arrival_airport_id) REFERENCES airport (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE flight ADD CONSTRAINT FK_C257E60EF53666A8 FOREIGN KEY (plane_id) REFERENCES plane (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE flight_passenger ADD CONSTRAINT FK_25F7F56F91F478C5 FOREIGN KEY (flight_id) REFERENCES flight (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE flight_passenger ADD CONSTRAINT FK_25F7F56F4502E565 FOREIGN KEY (passenger_id) REFERENCES passenger (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE flight_personal ADD CONSTRAINT FK_E865B71691F478C5 FOREIGN KEY (flight_id) REFERENCES flight (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE flight_personal ADD CONSTRAINT FK_E865B7165D430949 FOREIGN KEY (personal_id) REFERENCES personal (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE luggage ADD CONSTRAINT FK_5907C8DA4502E565 FOREIGN KEY (passenger_id) REFERENCES passenger (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE airport ADD CONSTRAINT FK_7E91F7C28BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE personal ADD CONSTRAINT FK_F18A6D84979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE flight DROP CONSTRAINT FK_C257E60EF53666A8');
        $this->addSql('ALTER TABLE airport DROP CONSTRAINT FK_7E91F7C28BAC62AF');
        $this->addSql('ALTER TABLE flight_passenger DROP CONSTRAINT FK_25F7F56F91F478C5');
        $this->addSql('ALTER TABLE flight_personal DROP CONSTRAINT FK_E865B71691F478C5');
        $this->addSql('ALTER TABLE plane DROP CONSTRAINT FK_C1B32D80979B1AD6');
        $this->addSql('ALTER TABLE personal DROP CONSTRAINT FK_F18A6D84979B1AD6');
        $this->addSql('ALTER TABLE flight DROP CONSTRAINT FK_C257E60EF631AB5C');
        $this->addSql('ALTER TABLE flight DROP CONSTRAINT FK_C257E60E7F43E343');
        $this->addSql('ALTER TABLE flight_passenger DROP CONSTRAINT FK_25F7F56F4502E565');
        $this->addSql('ALTER TABLE luggage DROP CONSTRAINT FK_5907C8DA4502E565');
        $this->addSql('ALTER TABLE flight_personal DROP CONSTRAINT FK_E865B7165D430949');
        $this->addSql('DROP SEQUENCE plane_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE city_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE airplane_user_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE flight_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE luggage_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE company_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE airport_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE passenger_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE personal_id_seq CASCADE');
        $this->addSql('DROP TABLE plane');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE airplane_user');
        $this->addSql('DROP TABLE flight');
        $this->addSql('DROP TABLE flight_passenger');
        $this->addSql('DROP TABLE flight_personal');
        $this->addSql('DROP TABLE luggage');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE airport');
        $this->addSql('DROP TABLE passenger');
        $this->addSql('DROP TABLE personal');
    }
}
