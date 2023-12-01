<?php

namespace App\Service;

use App\Entity\Book;
use App\Repository\ReviewRepository;

class ReviewService
{
    public function __construct(
        private readonly ReviewRepository $reviewRepository,
    )
    {
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