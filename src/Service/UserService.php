<?php

namespace App\Service;

use App\Entity\Book;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class UserService
{

    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly Security $security
    )
    {

    }

    public function onUserExist(callable $f): void
    {
        if ($this->security->getUser() != null) {
            $f($this->getUser());
        }
    }

    public function getUser(): ?User
    {
        if ($this->security->getUser() == null) return null;
        return $this->userRepository->findByEmail($this->security->getUser()->getUserIdentifier());
    }

}