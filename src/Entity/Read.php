<?php

namespace App\Entity;

use App\Repository\ReadRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReadRepository::class)]
class Read
{

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: User::class)]
    private ?User $user = null;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Book::class)]
    private ?Book $book = null;

    #[ORM\ManyToOne(targetEntity: ReadingStatus::class)]
    private ?ReadingStatus $status = null;

    #[ORM\Column]
    private ?int $score = null;

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function getStatus(): ?ReadingStatus
    {
        return $this->status;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(?int $score): void
    {
        $this->score = $score;
    }

    public function setStatus(?ReadingStatus $status): void
    {
        $this->status = $status;
    }

}
