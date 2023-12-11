<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Enum\ReadingStatusEnum;
use App\Repository\BookRepository;
use App\Repository\ReviewRepository;
use App\Repository\UserRepository;
use App\Service\ReadService;
use App\Service\ReviewService;
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

        $booksReviewsReadsTuples = array_map(
            function(Book $book) use ($reviewRepository, $readService, $user) {
                $read = $readService->getReadFromBookAndUser($book, $user);
                if ($read === null) {
                    return null;
                }
                return [$book, $reviewRepository->findReviewByBookAndUser($book, $user), $read];
            },
            $books,
        );
        $booksReviewsReadsTuples = array_filter($booksReviewsReadsTuples, fn($any) => $any !== null);

        return $this->render('reading_list/index.html.twig', [
            'user' => $user,
            'booksReviewsReadsTuples' => $booksReviewsReadsTuples,
        ]);
    }

    #[Route('/{username}/book/{id}/reading', name: 'app_reading_list_reading', methods: ['GET'])]
    public function reading(string $username, Book $book, ReadService $readService): Response
    {
        $readService->changeState( $book, ReadingStatusEnum::Reading);
        return $this->redirectToRoute('app_reading_list', [ 'username' => $username ], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{username}/book/{id}/drop', name: 'app_reading_list_drop', methods: ['GET'])]
    public function drop(string $username, Book $book, ReadService $readService): Response
    {
        $readService->changeState($book, ReadingStatusEnum::Drop);
        return $this->redirectToRoute('app_reading_list', [ 'username' => $username ], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{username}/book/{id}/completed', name: 'app_reading_list_completed', methods: ['GET'])]
    public function completed(string $username, Book $book, ReadService $readService): Response
    {
        $readService->changeState($book, ReadingStatusEnum::Completed);
        return $this->redirectToRoute('app_reading_list', [ 'username' => $username ], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{username}/book/{id}/planToRead', name: 'app_reading_list_plan_to_read', methods: ['GET'])]
    public function planToRead(string $username, Book $book, ReadService $readService): Response
    {
        $readService->changeState($book, ReadingStatusEnum::PlanToRead);
        return $this->redirectToRoute('app_reading_list', [ 'username' => $username ], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{username}/book/{id}/remove', name: 'app_reading_list_remove', methods: ['GET'])]
    public function remove(string $username, Book $book, ReadService $readService, ReviewService $reviewService): Response
    {
        $readService->removeToList($book);
        $reviewService->remove($book);
        return $this->redirectToRoute('app_reading_list', [ 'username' => $username ], Response::HTTP_SEE_OTHER);
    }
}
