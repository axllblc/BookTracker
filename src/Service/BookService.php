<?php

namespace App\Service;

use App\Entity\Author;
use App\Entity\Book;
use function PHPUnit\Framework\callback;

class BookService
{

    public function __construct()
    {
    }

    public function mapAuthorsToString(Book $book): string
    {
        $getNameFunction = fn (Author $author) => $author->getName();
        $nameAuthorArray = array_map($getNameFunction, $book->getAuthors()->toArray());
        return implode(',', $nameAuthorArray);
    }

}