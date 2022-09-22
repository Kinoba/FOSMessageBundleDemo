<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220921151622 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE messages_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE messages_metadata_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE threads_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE threads_metadata_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE users_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE messages (id INT NOT NULL, thread_id INT DEFAULT NULL, sender_id INT DEFAULT NULL, body TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DB021E96E2904019 ON messages (thread_id)');
        $this->addSql('CREATE INDEX IDX_DB021E96F624B39D ON messages (sender_id)');
        $this->addSql('CREATE TABLE messages_metadata (id INT NOT NULL, message_id INT DEFAULT NULL, participant_id INT DEFAULT NULL, is_read BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5E0C941C537A1329 ON messages_metadata (message_id)');
        $this->addSql('CREATE INDEX IDX_5E0C941C9D1C3019 ON messages_metadata (participant_id)');
        $this->addSql('CREATE TABLE threads (id INT NOT NULL, created_by_id INT DEFAULT NULL, subject VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, is_spam BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6F8E3DDDB03A8386 ON threads (created_by_id)');
        $this->addSql('CREATE TABLE threads_metadata (id INT NOT NULL, thread_id INT DEFAULT NULL, participant_id INT DEFAULT NULL, is_deleted BOOLEAN NOT NULL, last_participant_message_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, last_message_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_BBDFBD96E2904019 ON threads_metadata (thread_id)');
        $this->addSql('CREATE INDEX IDX_BBDFBD969D1C3019 ON threads_metadata (participant_id)');
        $this->addSql('CREATE TABLE users (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E96E2904019 FOREIGN KEY (thread_id) REFERENCES threads (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E96F624B39D FOREIGN KEY (sender_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE messages_metadata ADD CONSTRAINT FK_5E0C941C537A1329 FOREIGN KEY (message_id) REFERENCES messages (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE messages_metadata ADD CONSTRAINT FK_5E0C941C9D1C3019 FOREIGN KEY (participant_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE threads ADD CONSTRAINT FK_6F8E3DDDB03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE threads_metadata ADD CONSTRAINT FK_BBDFBD96E2904019 FOREIGN KEY (thread_id) REFERENCES threads (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE threads_metadata ADD CONSTRAINT FK_BBDFBD969D1C3019 FOREIGN KEY (participant_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE messages_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE messages_metadata_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE threads_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE threads_metadata_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE users_id_seq CASCADE');
        $this->addSql('ALTER TABLE messages DROP CONSTRAINT FK_DB021E96E2904019');
        $this->addSql('ALTER TABLE messages DROP CONSTRAINT FK_DB021E96F624B39D');
        $this->addSql('ALTER TABLE messages_metadata DROP CONSTRAINT FK_5E0C941C537A1329');
        $this->addSql('ALTER TABLE messages_metadata DROP CONSTRAINT FK_5E0C941C9D1C3019');
        $this->addSql('ALTER TABLE threads DROP CONSTRAINT FK_6F8E3DDDB03A8386');
        $this->addSql('ALTER TABLE threads_metadata DROP CONSTRAINT FK_BBDFBD96E2904019');
        $this->addSql('ALTER TABLE threads_metadata DROP CONSTRAINT FK_BBDFBD969D1C3019');
        $this->addSql('DROP TABLE messages');
        $this->addSql('DROP TABLE messages_metadata');
        $this->addSql('DROP TABLE threads');
        $this->addSql('DROP TABLE threads_metadata');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
