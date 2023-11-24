<?php

namespace App\Entity;

use App\Repository\ReadRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReadRepository::class)]
#[ORM\UniqueConstraint(
    name: 'reading_unique',
    columns: ['user_id', 'book_id']
)]
class Read
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: Book::class)]
    private ?Book $book = null;

    #[ORM\ManyToOne(targetEntity: ReadingStatus::class)]
    private ?ReadingStatus $status = null;

    public function getId(): ?int
    {
        return $this->id;
    }

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

    public function setStatus(?ReadingStatus $status): void
    {
        $this->status = $status;
    }



}
