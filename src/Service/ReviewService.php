<?php

namespace App\Service;

use App\Entity\Book;
use App\Entity\Review;
use App\Repository\BookRepository;
use App\Repository\ReviewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class ReviewService
{
    public function __construct(
        private readonly ReviewRepository $reviewRepository,
        private readonly BookRepository $bookRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly UserService $userService,
    )
    {
    }

    /**
     * Find all visible reviews corresponding to the book set as parameter.
     *
     * @param Book $book
     * @return array
     */
    public function findAllVisibleReviewsFromBook(Book $book): array
    {
        $reviews = $this->reviewRepository->findReviewsByBook($book);
        return array_filter($reviews, fn (Review $review) => $review->isVisible());
    }

    /**
     * We calculate the average score for a book.
     *
     * @param Book $book
     * @return float|null
     */
    public function averageScoreBook(Book $book): float | null
    {
        $average = null;
        $reviewsByBook = $this->reviewRepository->findReviewsByBook($book);
        foreach ($reviewsByBook as $review) {
            $average += $review->getScore();
        }
        if ($average != null) {
            $average /= count($reviewsByBook);
        }
        return $average;
    }

    public function getCurrentUserReviewedBook(Book $book): ?Review
    {
        $user = $this->userService->getUser();
        if ($user != null) {
            return $this->reviewRepository->findReviewByBookAndUser($book, $user);
        }
        return null;
    }

    public function sendReview(Review $review): void
    {
        $review->setDate(new \DateTimeImmutable());
        $this->entityManager->persist($review);
        $this->entityManager->flush();
    }

    public function remove(Book $book)
    {
        $user = $this->userService->getUser();
        if ($user != null) {
            $review = $this->reviewRepository->findReviewByBookAndUser($book, $user);
            $this->entityManager->remove($review);
            $this->entityManager->flush();
        }
    }

}