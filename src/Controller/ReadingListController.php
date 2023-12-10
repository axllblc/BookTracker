<?php

namespace App\Controller;

use App\Repository\BookRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reading_list')]
class ReadingListController extends AbstractController
{
    #[Route('/{username}', name: 'app_reading_list')]
    public function index(string $username, UserRepository $userRepository, BookRepository $bookRepository): Response
    {
        $user = $userRepository->findOneBy(['username' => $username]);
        if ($user === null) {
            throw $this->createNotFoundException();
        }

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

        return $this->render('reading_list/index.html.twig', [
            'user' => $user,
            'books' => $books,
        ]);
    }
}
