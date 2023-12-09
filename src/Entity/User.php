<?php

namespace App\Entity;

use App\Repository\UserRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Serializable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
#[ORM\HasLifecycleCallbacks]
#[Vich\Uploadable]
class User implements UserInterface, PasswordAuthenticatedUserInterface, Serializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var ?string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 50, unique: true)]
    private ?string $username = null;

    #[ORM\Column(options: ['default' => false])]
    private ?bool $blocked = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $registrationDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $lastLoginDate = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $profilePicture = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $profilePictureUpdate = null;

    #[Vich\UploadableField(mapping: 'user_profile', fileNameProperty: 'profilePicture')]
    #[Assert\File(maxSize: "5M")]
    #[Assert\Image]
    private ?File $profilePictureFile = null;

    #[ORM\Column(options: ['default' => false])]
    private ?bool $public = null;

    #[ORM\ManyToMany(targetEntity: Book::class)]
    private Collection $books;


    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    public function __toString(): string
    {
        return "#$this->id – $this->username ($this->email)";
    }

    /**
     * Set default values before the User is persisted to the database.
     */
    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->registrationDate = new DateTime();
        $this->lastLoginDate = new DateTime();
        $this->blocked = false;
        $this->public = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function isPasswordSet(): bool {
        return !empty($this->password);
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function isBlocked(): ?bool
    {
        return $this->blocked;
    }

    public function setBlocked(bool $blocked): static
    {
        $this->blocked = $blocked;

        return $this;
    }

    public function getRegistrationDate(): ?DateTimeInterface
    {
        return $this->registrationDate;
    }

    public function setRegistrationDate(DateTimeInterface $registrationDate): static
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    public function getLastLoginDate(): ?DateTimeInterface
    {
        return $this->lastLoginDate;
    }

    public function setLastLoginDate(DateTimeInterface $lastLoginDate): static
    {
        $this->lastLoginDate = $lastLoginDate;

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

    public function getProfilePicture(): ?string
    {
        return $this->profilePicture;
    }

    public function setProfilePicture(?string $profilePicture): static
    {
        $this->profilePicture = $profilePicture;

        return $this;
    }

    public function isPublic(): ?bool
    {
        return $this->public;
    }

    public function setPublic(bool $public): static
    {
        $this->public = $public;

        return $this;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): static
    {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
        }

        return $this;
    }

    public function removeBook(Book $book): static
    {
        $this->books->removeElement($book);

        return $this;
    }

    public function getProfilePictureFile(): ?File
    {
        return $this->profilePictureFile;
    }

    public function setProfilePictureFile(?File $profilePictureFile): void
    {
        $this->profilePictureFile = $profilePictureFile;

        if ($profilePictureFile != null) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->profilePictureUpdate = new DateTime();
        }
    }

    public function getProfilePictureUpdate(): ?DateTimeInterface
    {
        return $this->profilePictureUpdate;
    }

    public function setProfilePictureUpdate(?DateTimeInterface $profilePictureUpdate): void
    {
        $this->profilePictureUpdate = $profilePictureUpdate;
    }

    public function serialize(): string
    {
        return serialize([
            $this->id,
            $this->email,
            $this->roles,
            $this->password,
            $this->username,
            $this->blocked,
            $this->registrationDate,
            $this->lastLoginDate,
            $this->description,
            $this->profilePicture,
            $this->profilePictureUpdate,
            $this->public,
        ]);
    }

    public function unserialize($data): void
    {
        list(
            $this->id,
            $this->email,
            $this->roles,
            $this->password,
            $this->username,
            $this->blocked,
            $this->registrationDate,
            $this->lastLoginDate,
            $this->description,
            $this->profilePicture,
            $this->profilePictureUpdate,
            $this->public,
        ) = unserialize($data);
    }
}
