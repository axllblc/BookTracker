<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231125120816 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE read_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reading_status_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE review_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_follow_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
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
        $this->addSql('CREATE TABLE user_follow (id INT NOT NULL, following_user_id INT NOT NULL, followed_user_id INT NOT NULL, request_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, accepted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D665F4D1896F387 ON user_follow (following_user_id)');
        $this->addSql('CREATE INDEX IDX_D665F4DAF2612FD ON user_follow (followed_user_id)');
        $this->addSql('CREATE UNIQUE INDEX user_follow_unique ON user_follow (following_user_id, followed_user_id)');
        $this->addSql('ALTER TABLE read ADD CONSTRAINT FK_98574167A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE read ADD CONSTRAINT FK_9857416716A2B381 FOREIGN KEY (book_id) REFERENCES book (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE read ADD CONSTRAINT FK_985741676BF700BD FOREIGN KEY (status_id) REFERENCES reading_status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C616A2B381 FOREIGN KEY (book_id) REFERENCES book (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C61EE4A582 FOREIGN KEY (emotion_id) REFERENCES emotion (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_follow ADD CONSTRAINT FK_D665F4D1896F387 FOREIGN KEY (following_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_follow ADD CONSTRAINT FK_D665F4DAF2612FD FOREIGN KEY (followed_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE read_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reading_status_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE review_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_follow_id_seq CASCADE');
        $this->addSql('ALTER TABLE read DROP CONSTRAINT FK_98574167A76ED395');
        $this->addSql('ALTER TABLE read DROP CONSTRAINT FK_9857416716A2B381');
        $this->addSql('ALTER TABLE read DROP CONSTRAINT FK_985741676BF700BD');
        $this->addSql('ALTER TABLE review DROP CONSTRAINT FK_794381C6A76ED395');
        $this->addSql('ALTER TABLE review DROP CONSTRAINT FK_794381C616A2B381');
        $this->addSql('ALTER TABLE review DROP CONSTRAINT FK_794381C61EE4A582');
        $this->addSql('ALTER TABLE user_follow DROP CONSTRAINT FK_D665F4D1896F387');
        $this->addSql('ALTER TABLE user_follow DROP CONSTRAINT FK_D665F4DAF2612FD');
        $this->addSql('DROP TABLE read');
        $this->addSql('DROP TABLE reading_status');
        $this->addSql('DROP TABLE review');
        $this->addSql('DROP TABLE user_follow');
    }
}
