<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function index(Request $request, BookRepository $bookRepository): Response
    {
        $search = $request->query->get('search') ?? '';

        $books = [];
        if ($search !== '') {
            $books = $bookRepository->findFiltered($search);
        }

        return $this->render('search/index.html.twig', [
            'books' => $books,
        ]);
    }
}
