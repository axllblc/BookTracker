<?php

namespace App\Controller;

use App\Form\AccountEmailType;
use App\Form\AccountPasswordType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/account')]
class AccountController extends AbstractController
{
    #[Route('/', name: 'app_account', methods: ['GET', 'POST'])]
    public function index(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = $userRepository->findOneBy(['email' => $this->getUser()->getUserIdentifier()]);
        if ($user === null) {
            dd('Unreachable: user should be fully authentificated');
        }

        $emailErrorMsg = '';
        $emailForm = $this->createForm(AccountEmailType::class, $user);
        $emailForm->handleRequest($request);

        $passwordErrorMsg = '';
        $passwordForm = $this->createForm(AccountPasswordType::class, $user);
        $passwordForm->handleRequest($request);

        if ($emailForm->isSubmitted() && $emailForm->isValid()) {
            $email = $emailForm->get('email')->getData();
            $email2 = $emailForm->get('email2')->getData();

            if (strcmp($email, $email2) == 0) {
                if (strcmp($email, $user->getEmail()) != 0) {
                    $entityManager->flush();
                    return $this->redirectToRoute('app_account', [], Response::HTTP_SEE_OTHER);
                }
            } else {
                $emailErrorMsg = 'The email addresses do not match.';
            }
        }

        if ($passwordForm->isSubmitted() && $passwordForm->isValid()) {
            $currentPlainPassword = $passwordForm->get('currentPlainPassword')->getData();
            $newPlainPassword = $passwordForm->get('newPlainPassword')->getData();
            $newPlainPassword2 = $passwordForm->get('newPlainPassword2')->getData();

            if ($passwordHasher->isPasswordValid($user, $currentPlainPassword)) {
                if (strcmp($newPlainPassword, $newPlainPassword2) == 0) {
                    $hash = $passwordHasher->hashPassword($user, $newPlainPassword);
                    $user->setPassword($hash);

                    $entityManager->flush();
                    return $this->redirectToRoute('app_account', [], Response::HTTP_SEE_OTHER);
                }
                $passwordErrorMsg = 'New passwords do not match.';
            } else {
                $passwordErrorMsg = 'Current password is incorrect.';
            }
        }

        return $this->render('account/index.html.twig', [
            'user' => $user,
            'emailForm' => $emailForm,
            'emailErrorMsg' => $emailErrorMsg,
            'passwordForm' => $passwordForm,
            'passwordErrorMsg' => $passwordErrorMsg,
        ]);
    }
}
