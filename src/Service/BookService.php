<?php

namespace App\Service;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Enum\ReadingStatusEnum;
use App\Repository\ReadingStatusRepository;
use App\Repository\ReadRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class BookService
{

    public function __construct(
        private readonly UserService $userService,
        private readonly EntityManagerInterface $entityManager,
        private readonly ReadRepository $readRepository,
        private readonly ReadingStatusRepository $readingStatusRepository
    )
    {
    }

    public function mapAuthorsToString(Book $book): string
    {
        $getNameFunction = fn (Author $author) => $author->getName();
        $nameAuthorArray = array_map($getNameFunction, $book->getAuthors()->toArray());
        return implode(',', $nameAuthorArray);
    }

    public function changeState(UserInterface $user, Book $book, ReadingStatusEnum $readingStatusEnum): void
    {
        $user = $this->userService->mapUserInterface($user);
        $read = $this->readRepository->findByBookAndUser($user, $book);
        $readStatus = $this->readingStatusRepository->findByStatus($readingStatusEnum);
        $read->setStatus($readStatus);
        $this->entityManager->persist($read);
        $this->entityManager->flush();
    }

}