<?php

namespace App\Service;

use App\Entity\Book;
use App\Entity\Enum\ReadingStatusEnum;
use App\Entity\Read;
use App\Entity\User;
use App\Repository\ReadingStatusRepository;
use App\Repository\ReadRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class ReadService
{

    public function __construct(
        private readonly ReadRepository $readRepository,
        private readonly UserService $userService,
        private readonly EntityManagerInterface $entityManager,
        private readonly ReadingStatusRepository $readingStatusRepository
    )
    {

    }

    public function getReadFromBookAndUser(Book $book, ?User $user): ?Read
    {
        if ($user == null) return null;
        return $this->readRepository->findByBookAndUser($user, $book);
    }

    public function removeToList(Book $book): void
    {
        $user = $this->userService->getUser();
        $read = $this->getReadFromBookAndUser($book, $user);
        $this->entityManager->remove($read);
        $this->entityManager->flush();
    }

    public function changeState(Book $book, ReadingStatusEnum $readingStatusEnum): void
    {
        $user = $this->userService->getUser();
        $read = $this->getReadFromBookAndUser($book, $user);
        $readStatus = $this->readingStatusRepository->findByStatus($readingStatusEnum);
        $read->setStatus($readStatus);
        $this->entityManager->persist($read);
        $this->entityManager->flush();
    }

    public function addToMyList(Book $book): void
    {
        $readStatus = $this->readingStatusRepository->findByStatus(ReadingStatusEnum::Reading);
        $user = $this->userService->getUser();
        $read = new Read();
        $read
            ->setBook($book)
            ->setUser($user)
            ->setStatus($readStatus);
        $this->entityManager->persist($read);
        $this->entityManager->flush();
    }


}