<?php

namespace App\Service;

use App\Entity\Book;
use App\Repository\BookRepository;

class EditorService
{

    public function __construct(
        private readonly BookRepository $bookRepository,
    )
    {
    }

    public function getEditors(): array
    {
        $books = $this->bookRepository->findAll();
        $editors = array_reduce($books, function (array $editors, Book $book) {
            if (strcmp($book->getEditor(), '') === 0) {
                return $editors;
            } else {
                $editors[] = $book->getEditor();
                return $editors;
            }
        }, []);

        return array_unique($editors);
    }
}
