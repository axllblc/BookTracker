<?php

namespace App\Controller\Admin;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\BookGenre;
use App\Entity\Contact;
use App\Entity\Emotion;
use App\Entity\Review;
use App\Entity\User;
use App\Security\RoleConstants;
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
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        // Users section
        // Allowed users: ROLE_ADMIN only
        if ($this->isGranted(RoleConstants::ROLE_ADMIN)) {
            yield MenuItem::section('Users');
            yield MenuItem::linkToCrud('Users', 'fa fa-user', User::class);
        }

        // Books section
        // Allowed users: ROLE_ADMIN, ROLE_CONTRIBUTOR
        if ($this->isGranted(RoleConstants::ROLE_CONTRIBUTOR)) {
            yield MenuItem::section('Books');
            yield MenuItem::linkToCrud('Books', 'fas fa-book', Book::class);
            yield MenuItem::linkToCrud('Authors', 'fa fa-user', Author::class);
            yield MenuItem::linkToCrud('Genres','fa fa-pen', BookGenre::class);
        }

        // Reviews section
        // Allowed users: ROLE_ADMIN, ROLE_MODERATOR
        if ($this->isGranted(RoleConstants::ROLE_MODERATOR)) {
            yield MenuItem::section('Reviews');
            yield MenuItem::linkToCrud('Reviews', 'fas fa-star-half-stroke', Review::class);
        }
        // Allowed users: ROLE_ADMIN only
        if ($this->isGranted(RoleConstants::ROLE_ADMIN)) {
            yield MenuItem::linkToCrud('Emotions', 'fa fa-face-smile', Emotion::class);
        }

        // Contact section
        if ($this->isGranted(RoleConstants::ROLE_ADMIN)) {
            yield MenuItem::section('Contact');
            yield MenuItem::linkToCrud('Contact messages', 'fa fa-envelope', Contact::class);
        }

    }
}
