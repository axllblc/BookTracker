<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231211152738 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_follow DROP FOREIGN KEY FK_D665F4D1896F387');
        $this->addSql('ALTER TABLE user_follow DROP FOREIGN KEY FK_D665F4DAF2612FD');
        $this->addSql('ALTER TABLE user_follow ADD CONSTRAINT FK_D665F4D1896F387 FOREIGN KEY (following_user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_follow ADD CONSTRAINT FK_D665F4DAF2612FD FOREIGN KEY (followed_user_id) REFERENCES `user` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_follow DROP FOREIGN KEY FK_D665F4D1896F387');
        $this->addSql('ALTER TABLE user_follow DROP FOREIGN KEY FK_D665F4DAF2612FD');
        $this->addSql('ALTER TABLE user_follow ADD CONSTRAINT FK_D665F4D1896F387 FOREIGN KEY (following_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_follow ADD CONSTRAINT FK_D665F4DAF2612FD FOREIGN KEY (followed_user_id) REFERENCES user (id)');
    }
}
