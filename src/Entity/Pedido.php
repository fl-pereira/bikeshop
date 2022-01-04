<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table("pedidos")
 */
class Pedido
{
    /**
    * @ORM\Id
    * @ORM\GeneratedValue
    * @ORM\Column(type="integer")
    */
    private $id;

    /**
    * @ORM\Column(type="string", length=255)
    */
    private $nome;

    /**
    * @ORM\Column(type="string", length=255)
    */
    private $mail;

    /**
    * @ORM\Column(type="text")
    */
    private $endereco;

    /**
    * @ORM\ManyToMany(targetEntity="Produto")
    */
    private $produtos;

    public function __construct()
    {
        $this->produtos = new ArrayCollection;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getEndereco(): ?string
    {
        return $this->endereco;
    }

    public function setEndereco(string $endereco): self
    {
        $this->endereco = $endereco;

        return $this;
    }

    public function getProdutos()
    {
        return $this->produtos;
    }

}
