<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{

    #[Route('/contact', name: 'contact.index')]
    public function index(
        Request $request,
        EntityManagerInterface $manager): Response
    {
        $contact = new Contact();

        if($this->getUser()) {
            $contact->setUsername($this->getUser()->getUsername())
            ->setEmail($this->getUser()->getEmail());
        }

        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();

            $manager->persist($contact);
            $manager->flush();

            $this->addFlash(
                'sucess','Votre message a été envoyé !'
            );

            return $this->redirectToRoute('contact.index');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
