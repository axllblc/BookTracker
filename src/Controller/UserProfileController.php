<?php

namespace App\Controller;

use App\Form\UserProfileType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class UserProfileController extends AbstractController
{
    #[Route('/user/{username}', name: 'app_user_profile', methods: ['GET'])]
    public function index(string $username, UserRepository $userRepository): Response
    {
        $user = $userRepository->findOneBy(['username' => $username]);
        if ($user === null) {
            dd('TODO: 404');
        }

        return $this->render('user_profile/index.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/profile', name: 'app_user_profile_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        if ($this->getUser() === null) {
            dd('Unreachable: unauthentificated users should not see this route');
        }

        $user = $userRepository->findOneBy(['email' => $this->getUser()->getUserIdentifier()]);
        if ($user === null) {
            dd('Unreachable: the user is authentificated but somehow they are not persisted in the database??');
        }

        $form = $this->createForm(UserProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_user_profile', ['username' => $user->getUsername()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user_profile/edit.html.twig', [
            'form' => $form,
        ]);
    }
}
