<?php

namespace App\Entity;

use App\Repository\ReadingStatusRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReadingStatusRepository::class)]
class ReadingStatus
{

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: User::class)]
    private ?User $user = null;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Book::class)]
    private ?Book $book = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }
}
