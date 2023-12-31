<?php

namespace App\Entity;

use App\Entity\Enum\ReadingStatusEnum;
use App\Repository\ReadingStatusRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReadingStatusRepository::class)]
class ReadingStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?ReadingStatusEnum $status = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?ReadingStatusEnum
    {
        return $this->status;
    }

    public function setStatus(ReadingStatusEnum $status): static
    {
        $this->status = $status;

        return $this;
    }
}
