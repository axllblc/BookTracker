<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Enum\ReadingStatusEnum;
use App\Entity\Review;
use App\Entity\User;
use App\Form\ReviewType;
use App\Service\ReadService;
use App\Service\ReviewService;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{

    #[Route('/book/{id}', name: 'app_book', methods: ['POST', 'GET'])]
    public function index(Request $request,
                          Book $book,
                          UserService $userService,
                          ReadService $readService,
                          ReviewService $reviewService): Response
    {

        $userReview = $reviewService->getCurrentUserReviewedBook($book);
        $review = $userReview == null ? new Review() : $userReview;
        $reviewForm = $this->createForm(ReviewType::class, $review);

        $userService->onUserExist(fn (User $user) => $review
            ->setUser($user)
            ->setBook($book)
        );

        $reviewForm->handleRequest($request);

        if ($reviewForm->isSubmitted() && $reviewForm->isValid()) {
            $reviewService->sendReview($review);
            return $this->redirectToRoute('app_book', ['id' => $book->getId()]);
        }

        return $this->render('book/index.html.twig', [
            'book' => $book,
            'userReview' => $userReview,
            'reviewForm' => $reviewForm->createView(),
            'read' => $readService->getReadFromBookAndUser($book, $userService->getUser()),
            'currentUser' => $userService->getUser(),
            'hasCurrentUser' => $userService->getUser() != null,
            'averageScore' => $reviewService->averageScoreBook($book),
            'reviews' => $reviewService->findAllVisibleReviewsFromBook($book)
        ]);
    }

    #[Route('/book/{id}/remove_review', name: 'app_book_remove_review', methods: ['GET'])]
    public function removeReview(Book $book, ReviewService $reviewService): Response
    {
        $reviewService->remove($book);
        return $this->redirectToRoute('app_book', [ 'id' => $book->getId() ], Response::HTTP_SEE_OTHER);
    }

    #[Route('/book/{id}/reading', name: 'app_book_reading', methods: ['GET'])]
    public function reading(Book $book, ReadService $readService): Response
    {
        $readService->changeState( $book, ReadingStatusEnum::Reading);
        return $this->redirectToRoute('app_book', [ 'id' => $book->getId() ], Response::HTTP_SEE_OTHER);
    }

    #[Route('/book/{id}/drop', name: 'app_book_drop', methods: ['GET'])]
    public function drop(Book $book, ReadService $readService): Response
    {
        $readService->changeState($book, ReadingStatusEnum::Drop);
        return $this->redirectToRoute('app_book', [ 'id' => $book->getId() ], Response::HTTP_SEE_OTHER);
    }

    #[Route('/book/{id}/completed', name: 'app_book_completed', methods: ['GET'])]
    public function completed(Book $book, ReadService $readService): Response
    {
        $readService->changeState($book, ReadingStatusEnum::Completed);
        return $this->redirectToRoute('app_book', [ 'id' => $book->getId() ], Response::HTTP_SEE_OTHER);
    }

    #[Route('/book/{id}/planToRead', name: 'app_book_plan_to_read', methods: ['GET'])]
    public function planToRead(Book $book, ReadService $readService): Response
    {
        $readService->changeState($book, ReadingStatusEnum::PlanToRead);
        return $this->redirectToRoute('app_book', [ 'id' => $book->getId() ], Response::HTTP_SEE_OTHER);
    }

    #[Route('/book/{id}/add', name: 'app_book_add', methods: ['GET'])]
    public function add(Book $book, ReadService $readService): Response
    {
        if ($this->getUser() == null)
            return $this->redirectToRoute('app_login');

        $readService->addToMyList($book);
        return $this->redirectToRoute('app_book', [ 'id' => $book->getId() ], Response::HTTP_SEE_OTHER);
    }

    #[Route('/book/{id}/remove', name: 'app_book_remove', methods: ['GET'])]
    public function remove(Book $book, ReadService $readService, ReviewService $reviewService): Response
    {
        $readService->removeToList($book);
        $reviewService->remove($book);
        return $this->redirectToRoute('app_book', [ 'id' => $book->getId() ], Response::HTTP_SEE_OTHER);
    }

}
