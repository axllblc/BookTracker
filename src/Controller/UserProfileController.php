<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class UserProfileController extends AbstractController
{
    #[Route('/{username}', name: 'app_user_profile_show', methods: ['GET'])]
    public function show(string $username, UserRepository $userRepository): Response
    {
        $user = $userRepository->findOneBy(['username' => $username]);
        if ($user === null) {
            dd('TODO: 404');
        }

        return $this->render('user_profile/index.html.twig', [
            'user' => $user,
        ]);
    }
}
