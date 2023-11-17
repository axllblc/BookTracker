<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 13, nullable: true, unique: true)]
    private ?string $isbn = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $publication = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $coverPicture = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $editor = null;

    #[ORM\ManyToOne]
    private ?User $addedBy = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $addedAt = null;

    #[ORM\ManyToOne]
    private ?User $lastEditBy = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $lastEditAt = null;

    #[ORM\ManyToOne(inversedBy: 'books')]
    private ?BookGenre $genre = null;

    #[ORM\ManyToMany(targetEntity: Author::class, mappedBy: 'books')]
    private Collection $authors;

    public function __construct()
    {
        $this->authors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(?string $isbn): static
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getPublication(): ?\DateTimeInterface
    {
        return $this->publication;
    }

    public function setPublication(?\DateTimeInterface $publication): static
    {
        $this->publication = $publication;

        return $this;
    }

    public function getCoverPicture(): ?string
    {
        return $this->coverPicture;
    }

    public function setCoverPicture(?string $coverPicture): static
    {
        $this->coverPicture = $coverPicture;

        return $this;
    }

    public function getEditor(): ?string
    {
        return $this->editor;
    }

    public function setEditor(?string $editor): static
    {
        $this->editor = $editor;

        return $this;
    }

    public function getAddedBy(): ?User
    {
        return $this->addedBy;
    }

    public function setAddedBy(?User $addedBy): static
    {
        $this->addedBy = $addedBy;

        return $this;
    }

    public function getAddedAt(): ?\DateTimeInterface
    {
        return $this->addedAt;
    }

    public function setAddedAt(?\DateTimeInterface $addedAt): static
    {
        $this->addedAt = $addedAt;

        return $this;
    }

    public function getLastEditBy(): ?User
    {
        return $this->lastEditBy;
    }

    public function setLastEditBy(?User $lastEditBy): static
    {
        $this->lastEditBy = $lastEditBy;

        return $this;
    }

    public function getLastEditAt(): ?\DateTimeInterface
    {
        return $this->lastEditAt;
    }

    public function setLastEditAt(?\DateTimeInterface $lastEditAt): static
    {
        $this->lastEditAt = $lastEditAt;

        return $this;
    }

    public function getGenre(): ?BookGenre
    {
        return $this->genre;
    }

    public function setGenre(?BookGenre $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * @return Collection<int, Author>
     */
    public function getAuthors(): Collection
    {
        return $this->authors;
    }

    public function addAuthor(Author $author): static
    {
        if (!$this->authors->contains($author)) {
            $this->authors->add($author);
            $author->addBook($this);
        }

        return $this;
    }

    public function removeAuthor(Author $author): static
    {
        if ($this->authors->removeElement($author)) {
            $author->removeBook($this);
        }

        return $this;
    }
}
