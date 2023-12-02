<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Enum\ReadingStatusEnum;
use App\Entity\ReadingStatus;
use App\Repository\BookRepository;
use App\Repository\ReadRepository;
use App\Repository\ReviewRepository;
use App\Service\BookService;
use App\Service\ReadService;
use App\Service\ReviewService;
use App\Service\UserService;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{

    #[Route('/book/{id}', name: 'app_book')]
    public function index(Book $book, UserService $userService, ReadService $readService, ReviewService $reviewService, Security $security): Response
    {
        $user = $userService->mapUserInterface($security->getUser());

        return $this->render('book/index.html.twig', [
            'book' => $book,
            'read' => $readService->getReadFromBookAndUser($book, $user),
            'currentUser' => $user,
            'hasCurrentUser' => $user != null,
            'averageScore' => $reviewService->averageScoreBook($book),
            'reviews' => $reviewService->findAllVisibleReviewsFromBook($book)
        ]);
    }

    #[Route('/book/{id}', name: 'app_book_reading', methods: ['POST'])]
    public function reading(Book $book, BookService $bookService): Response
    {
        $bookService->changeState($this->getUser(), $book, ReadingStatusEnum::Reading);
        return $this->redirectToRoute('app_book', [ 'id' => $book->getId() ], Response::HTTP_SEE_OTHER);
    }

    #[Route('/book/{id}', name: 'app_book_drop', methods: ['POST'])]
    public function drop(Book $book, BookService $bookService): Response
    {
        $bookService->changeState($this->getUser(), $book, ReadingStatusEnum::Drop);
        return $this->redirectToRoute('app_book', [ 'id' => $book->getId() ], Response::HTTP_SEE_OTHER);
    }

    #[Route('/book/{id}', name: 'app_book_completed', methods: ['POST'])]
    public function completed(Book $book, BookService $bookService): Response
    {
        $bookService->changeState($this->getUser(), $book, ReadingStatusEnum::Completed);
        return $this->redirectToRoute('app_book', [ 'id' => $book->getId() ], Response::HTTP_SEE_OTHER);
    }

    #[Route('/book/{id}', name: 'app_book_plan_to_read', methods: ['POST'])]
    public function planToRead(Book $book, BookService $bookService): Response
    {
        $bookService->changeState($this->getUser(), $book, ReadingStatusEnum::PlanToRead);
        return $this->redirectToRoute('app_book', [ 'id' => $book->getId() ], Response::HTTP_SEE_OTHER);
    }

}
