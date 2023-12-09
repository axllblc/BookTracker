<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookGenreRepository;
use App\Repository\BookRepository;
use App\Service\EditorService;
use DateTime;
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
        $dateBegin = $request->query->get('date-begin') ?? '';
        $dateEnd = $request->query->get('date-end') ?? '';

        $books = [];
        if ($search !== '') {
            $books = $bookRepository->findFiltered($search);

            if ($genre !== 0) {
                $books = array_filter($books, fn (Book $book) => $book->getGenre()?->getId() === $genre);
            }
            if ($editor !== '0') {
                $books = array_filter($books, fn (Book $book) => $book->getEditor() === $editor);
            }
            if ($dateBegin !== '' || $dateEnd !== '') {
                $dateBegin = DateTime::createFromFormat('Y-m-d', $dateBegin ?: '0000-00-00')->getTimestamp();
                $dateEnd = DateTime::createFromFormat('Y-m-d', $dateEnd ?: date('Y-m-d'))->getTimestamp();

                $books = array_filter($books, function (Book $book) use ($dateEnd, $dateBegin) {
                    $date = $book->getPublication()?->getTimestamp();
                    return $date !== null && $dateBegin <= $date && $date <= $dateEnd;
                });
            }
        }

        return $this->render('search/index.html.twig', [
            'books' => $books,
            'genres' => $bookGenreRepository->findAll(),
            'editors' => $editorService->getEditors(),
        ]);
    }
}
