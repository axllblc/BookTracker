<?php

namespace App\Controller\Admin;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\BookGenre;
use App\Entity\Emotion;
use App\Entity\Review;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{


    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('BookTracker');
    }

    public function configureMenuItems(): iterable
    {
        return [

            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),

            // Section users
            MenuItem::section('Users'),
            MenuItem::linkToCrud('Users', 'fa fa-user', User::class),
            MenuItem::linkToCrud('Emotions', 'fa fa-face-smile', Emotion::class),

            // Section books
            MenuItem::section('Books'),
            MenuItem::linkToCrud('Books', 'fas fa-book', Book::class),
            MenuItem::linkToCrud('Authors', 'fa fa-user', Author::class),
            MenuItem::linkToCrud('Reviews', 'fas fa-star-half-stroke', Review::class),
            MenuItem::linkToCrud('Genres','fa fa-pen', BookGenre::class)
        ];
    }
}
