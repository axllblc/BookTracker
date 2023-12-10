<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use App\Repository\ReviewRepository;
use App\Repository\UserRepository;
use App\Service\ReadService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reading_list')]
class ReadingListController extends AbstractController
{
    #[Route('/{username}', name: 'app_reading_list')]
    public function index(string $username,
                          UserRepository $userRepository,
                          BookRepository $bookRepository,
                          ReviewRepository $reviewRepository,
                          ReadService $readService,): Response
    {
        $user = $userRepository->findOneBy(['username' => $username]);
        if ($user === null) {
            throw $this->createNotFoundException();
        }

        $books = $bookRepository->findAll();
        $books = array_filter($books, fn(Book $book) => $readService->getReadFromBookAndUser($book, $user) !== null);
        $booksWithReview = array_map(
            fn(Book $book) => [$book, $reviewRepository->findReviewByBookAndUser($book, $user)],
            $books,
        );

        return $this->render('reading_list/index.html.twig', [
            'user' => $user,
            'booksWithReview' => $booksWithReview,
        ]);
    }
}
