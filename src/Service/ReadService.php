<?php

namespace App\Service;

use App\Entity\Book;
use App\Entity\Read;
use App\Entity\User;
use App\Repository\ReadRepository;

class ReadService
{

    public function __construct(
        private readonly ReadRepository $readRepository,
    )
    {

    }

    public function getReadFromBookAndUser(Book $book, ?User $user): ?Read
    {
        if ($user == null) return null;
        return $this->readRepository->findByBookAndUser($user, $book);
    }

}