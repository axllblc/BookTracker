<?php

namespace App\Service;

use App\Entity\Author;
use App\Entity\Book;
use App\Repository\BookRepository;
use App\Repository\UserRepository;
use function PHPUnit\Framework\callback;

class BookService
{

    public function __construct(
        private readonly BookRepository $bookRepository,
        private readonly UserRepository $userRepository,
    )
    {
    }

    public function mapAuthorsToString(Book $book): string
    {
        $getNameFunction = fn (Author $author) => $author->getName();
        $nameAuthorArray = array_map($getNameFunction, $book->getAuthors()->toArray());
        return implode(', ', $nameAuthorArray);
    }

}