<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210930132230 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pedidos (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, endereco LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pedido_produto (pedido_id INT NOT NULL, produto_id INT NOT NULL, INDEX IDX_3ED5C1B94854653A (pedido_id), INDEX IDX_3ED5C1B9105CFD56 (produto_id), PRIMARY KEY(pedido_id, produto_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pedido_produto ADD CONSTRAINT FK_3ED5C1B94854653A FOREIGN KEY (pedido_id) REFERENCES pedidos (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pedido_produto ADD CONSTRAINT FK_3ED5C1B9105CFD56 FOREIGN KEY (produto_id) REFERENCES produto (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pedido_produto DROP FOREIGN KEY FK_3ED5C1B94854653A');
        $this->addSql('DROP TABLE pedidos');
        $this->addSql('DROP TABLE pedido_produto');
    }
}
