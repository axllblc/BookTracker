<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231130191927 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE author_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE book_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE book_genre_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE emotion_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE read_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reading_status_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE review_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_follow_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE author (id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, birth_day DATE DEFAULT NULL, death_date DATE DEFAULT NULL, picture VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE author_book (author_id INT NOT NULL, book_id INT NOT NULL, PRIMARY KEY(author_id, book_id))');
        $this->addSql('CREATE INDEX IDX_2F0A2BEEF675F31B ON author_book (author_id)');
        $this->addSql('CREATE INDEX IDX_2F0A2BEE16A2B381 ON author_book (book_id)');
        $this->addSql('CREATE TABLE book (id INT NOT NULL, added_by_id INT DEFAULT NULL, last_edit_by_id INT DEFAULT NULL, genre_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, isbn VARCHAR(13) DEFAULT NULL, publication DATE DEFAULT NULL, cover_picture VARCHAR(255) DEFAULT NULL, cover_picture_update TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, editor VARCHAR(255) DEFAULT NULL, added_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, last_edit_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CBE5A331CC1CF4E6 ON book (isbn)');
        $this->addSql('CREATE INDEX IDX_CBE5A33155B127A4 ON book (added_by_id)');
        $this->addSql('CREATE INDEX IDX_CBE5A3317A213F93 ON book (last_edit_by_id)');
        $this->addSql('CREATE INDEX IDX_CBE5A3314296D31F ON book (genre_id)');
        $this->addSql('CREATE TABLE book_genre (id INT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE emotion (id INT NOT NULL, label VARCHAR(255) NOT NULL, emoji VARCHAR(8) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE read (id INT NOT NULL, user_id INT DEFAULT NULL, book_id INT DEFAULT NULL, status_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_98574167A76ED395 ON read (user_id)');
        $this->addSql('CREATE INDEX IDX_9857416716A2B381 ON read (book_id)');
        $this->addSql('CREATE INDEX IDX_985741676BF700BD ON read (status_id)');
        $this->addSql('CREATE UNIQUE INDEX reading_unique ON read (user_id, book_id)');
        $this->addSql('CREATE TABLE reading_status (id INT NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE review (id INT NOT NULL, user_id INT DEFAULT NULL, book_id INT DEFAULT NULL, emotion_id INT DEFAULT NULL, review VARCHAR(255) DEFAULT NULL, score INT DEFAULT NULL, visible BOOLEAN DEFAULT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_794381C6A76ED395 ON review (user_id)');
        $this->addSql('CREATE INDEX IDX_794381C616A2B381 ON review (book_id)');
        $this->addSql('CREATE INDEX IDX_794381C61EE4A582 ON review (emotion_id)');
        $this->addSql('CREATE UNIQUE INDEX review_unique ON review (user_id, book_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(50) NOT NULL, blocked BOOLEAN DEFAULT false NOT NULL, registration_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, last_login_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, description TEXT DEFAULT NULL, profile_picture VARCHAR(255) DEFAULT NULL, profile_picture_update TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, public BOOLEAN DEFAULT false NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON "user" (username)');
        $this->addSql('CREATE TABLE user_book (user_id INT NOT NULL, book_id INT NOT NULL, PRIMARY KEY(user_id, book_id))');
        $this->addSql('CREATE INDEX IDX_B164EFF8A76ED395 ON user_book (user_id)');
        $this->addSql('CREATE INDEX IDX_B164EFF816A2B381 ON user_book (book_id)');
        $this->addSql('CREATE TABLE user_follow (id INT NOT NULL, following_user_id INT NOT NULL, followed_user_id INT NOT NULL, request_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, accepted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D665F4D1896F387 ON user_follow (following_user_id)');
        $this->addSql('CREATE INDEX IDX_D665F4DAF2612FD ON user_follow (followed_user_id)');
        $this->addSql('CREATE UNIQUE INDEX user_follow_unique ON user_follow (following_user_id, followed_user_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE author_book ADD CONSTRAINT FK_2F0A2BEEF675F31B FOREIGN KEY (author_id) REFERENCES author (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE author_book ADD CONSTRAINT FK_2F0A2BEE16A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A33155B127A4 FOREIGN KEY (added_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A3317A213F93 FOREIGN KEY (last_edit_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A3314296D31F FOREIGN KEY (genre_id) REFERENCES book_genre (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE read ADD CONSTRAINT FK_98574167A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE read ADD CONSTRAINT FK_9857416716A2B381 FOREIGN KEY (book_id) REFERENCES book (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE read ADD CONSTRAINT FK_985741676BF700BD FOREIGN KEY (status_id) REFERENCES reading_status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C616A2B381 FOREIGN KEY (book_id) REFERENCES book (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C61EE4A582 FOREIGN KEY (emotion_id) REFERENCES emotion (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_book ADD CONSTRAINT FK_B164EFF8A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_book ADD CONSTRAINT FK_B164EFF816A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_follow ADD CONSTRAINT FK_D665F4D1896F387 FOREIGN KEY (following_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_follow ADD CONSTRAINT FK_D665F4DAF2612FD FOREIGN KEY (followed_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE author_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE book_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE book_genre_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE emotion_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE read_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reading_status_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE review_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE user_follow_id_seq CASCADE');
        $this->addSql('ALTER TABLE author_book DROP CONSTRAINT FK_2F0A2BEEF675F31B');
        $this->addSql('ALTER TABLE author_book DROP CONSTRAINT FK_2F0A2BEE16A2B381');
        $this->addSql('ALTER TABLE book DROP CONSTRAINT FK_CBE5A33155B127A4');
        $this->addSql('ALTER TABLE book DROP CONSTRAINT FK_CBE5A3317A213F93');
        $this->addSql('ALTER TABLE book DROP CONSTRAINT FK_CBE5A3314296D31F');
        $this->addSql('ALTER TABLE read DROP CONSTRAINT FK_98574167A76ED395');
        $this->addSql('ALTER TABLE read DROP CONSTRAINT FK_9857416716A2B381');
        $this->addSql('ALTER TABLE read DROP CONSTRAINT FK_985741676BF700BD');
        $this->addSql('ALTER TABLE review DROP CONSTRAINT FK_794381C6A76ED395');
        $this->addSql('ALTER TABLE review DROP CONSTRAINT FK_794381C616A2B381');
        $this->addSql('ALTER TABLE review DROP CONSTRAINT FK_794381C61EE4A582');
        $this->addSql('ALTER TABLE user_book DROP CONSTRAINT FK_B164EFF8A76ED395');
        $this->addSql('ALTER TABLE user_book DROP CONSTRAINT FK_B164EFF816A2B381');
        $this->addSql('ALTER TABLE user_follow DROP CONSTRAINT FK_D665F4D1896F387');
        $this->addSql('ALTER TABLE user_follow DROP CONSTRAINT FK_D665F4DAF2612FD');
        $this->addSql('DROP TABLE author');
        $this->addSql('DROP TABLE author_book');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE book_genre');
        $this->addSql('DROP TABLE emotion');
        $this->addSql('DROP TABLE read');
        $this->addSql('DROP TABLE reading_status');
        $this->addSql('DROP TABLE review');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE user_book');
        $this->addSql('DROP TABLE user_follow');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
