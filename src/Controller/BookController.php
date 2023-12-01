<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use App\Repository\ReviewRepository;
use App\Service\ReviewService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{

    #[Route('/book/{id}', name: 'app_book')]
    public function index(Book $book, ReviewService $reviewService, Security $security): Response
    {

        return $this->render('book/index.html.twig', [
            'currentUser' => $security->getUser(),
            'book' => $book,
            'averageScore' => $reviewService->averageScoreBook($book),
            'reviews' => $reviewService->findAllVisibleReviewsFromBook($book)
        ]);

    }

}
