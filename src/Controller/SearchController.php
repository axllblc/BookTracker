<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookGenreRepository;
use App\Repository\BookRepository;
use App\Service\EditorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function index(Request $request, BookRepository $bookRepository, BookGenreRepository $bookGenreRepository, EditorService $editorService): Response
    {
        $search = $request->query->get('search') ?? '';
        $genre = (int)$request->query->get('genre') ?? 0;
        $editor = $request->query->get('editor') ?? '0';

        $books = $bookRepository->findFiltered($search);
        $books = array_filter($books, fn (Book $book) => $book->getGenre()?->getId() == $genre);
        $books = array_filter($books, fn (Book $book) => $editor == 0 || strcmp($book->getEditor(), $editor) === 0);

        return $this->render('search/index.html.twig', [
            'books' => $books,
            'genres' => $bookGenreRepository->findAll(),
            'editors' => $editorService->getEditors(),
        ]);
    }
}
