<?php

namespace App\Service;

use App\Entity\Book;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\User\UserInterface;

class UserService
{

    public function __construct(
        private readonly UserRepository $userRepository
    )
    {

    }

    public function mapUserInterface(?UserInterface $user): ?User
    {
        if ($user == null) return null;
        return $this->userRepository->findByEmail($user->getUserIdentifier());
    }

}