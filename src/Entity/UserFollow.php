<?php

namespace App\Entity;

use App\Repository\UserFollowRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Relationship between two {@link User}s, with extra attributes.
 *
 * A user can follow many users and can be followed by many users.
 * This relationship is unidirectional: if a user A follows a user B, A is not necessarily followed by B.
 */
#[ORM\Entity(repositoryClass: UserFollowRepository::class)]
#[ORM\UniqueConstraint(
    name: 'user_follow_unique',
    columns: ['following_user_id', 'followed_user_id']
)]
class UserFollow
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $followingUser;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $followedUser;

    /**
     * @var DateTimeInterface|null Date when {@link followingUser} requested to follow {@link followedUser}.
     */
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $requestDate = null;

    /**
     * @var DateTimeInterface|null Date when {@link followedUser} accepted {@link followingUser}'s invitation.
     * If {@link followedUser}'s profile is private, this value is null until this request is accepted.
     */
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true, options: ['default' => null])]
    private ?DateTimeInterface $acceptedAt = null;


    public function __construct(?User $followingUser = null, ?User $followedUser = null)
    {
        $this->followingUser = $followingUser;
        $this->followedUser = $followedUser;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFollowingUser(): ?User
    {
        return $this->followingUser;
    }

    public function setFollowingUser(?User $followingUser): static
    {
        $this->followingUser = $followingUser;

        return $this;
    }

    public function getFollowedUser(): ?User
    {
        return $this->followedUser;
    }

    public function setFollowedUser(?User $followedUser): static
    {
        $this->followedUser = $followedUser;

        return $this;
    }

    public function getRequestDate(): ?DateTimeInterface
    {
        return $this->requestDate;
    }

    public function setRequestDate(DateTimeInterface $requestDate): static
    {
        $this->requestDate = $requestDate;

        return $this;
    }

    public function getAcceptedAt(): ?DateTimeInterface
    {
        return $this->acceptedAt;
    }

    public function setAcceptedAt(?DateTimeInterface $acceptedAt): static
    {
        $this->acceptedAt = $acceptedAt;

        return $this;
    }

    /**
     * @return bool true if {@link followedUser} accepted {@link followingUser}'s invitation, false otherwise.
     */
    public function isAccepted(): bool
    {
        return !is_null($this->acceptedAt);
    }
}
