<?php

namespace App\Service;

use App\Entity\Book;
use App\Entity\Review;
use App\Repository\ReviewRepository;

class ReviewService
{
    public function __construct(
        private readonly ReviewRepository $reviewRepository,
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

}