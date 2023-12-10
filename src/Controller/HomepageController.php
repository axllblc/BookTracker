<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(BookRepository $bookRepository): Response
    {
        $books = $bookRepository->findAll();
        $randomKeys = array_rand($books, 3);
        if ($randomKeys === null) {
            // #style: It's tempting to make it fail hard if we don't
            //         have enough books registered in the database.
            $books = null;
        } else {
            $books = array_filter($books,
                                  fn(int $bookId) => in_array($bookId, $randomKeys),
                                  ARRAY_FILTER_USE_KEY);
            shuffle($books);
        }

        return $this->render('homepage/index.html.twig', [
            'books' => $books,
        ]);
    }
}
