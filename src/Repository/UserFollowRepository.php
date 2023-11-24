<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\UserFollow;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserFollow>
 *
 * @method UserFollow|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserFollow|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserFollow[]    findAll()
 * @method UserFollow[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserFollowRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserFollow::class);
    }

    /**
     * Find {@link User}s following {@link followedUser}.
     * @param User $followedUser A User
     * @param bool|null $accepted null to get both accepted and not yet accepted invitations,
     *                            true to get only accepted invitations, false to get not yet accepted invitations
     * @return UserFollow[] Returns an array of UserFollow objects
     */
    public function findFollowingUsers(User $followedUser, ?bool $accepted = null): array {
        $qb = $this->createQueryBuilder('u')
            ->andWhere('u.followedUser = :user_id')
            ->setParameter('user_id', $followedUser->getId());

        $this->addIsAcceptedCondition($qb, $accepted);

        return $qb->getQuery()->getResult();
    }

    /**
     * Find {@link User}s followed by {@link followingUser}.
     * @param User $followingUser A User
     * @param bool|null $accepted null to get both accepted and not yet accepted invitations,
     *                            true to get only accepted invitations, false to get not yet accepted invitations
     * @return UserFollow[] Returns an array of UserFollow objects
     */
    public function findFollowedUsers(User $followingUser, ?bool $accepted = null): array {
        $qb = $this->createQueryBuilder('u')
            ->andWhere('u.followingUser = :user_id')
            ->setParameter('user_id', $followingUser->getId());

        $this->addIsAcceptedCondition($qb, $accepted);

        return $qb->getQuery()->getResult();
    }

    private static function addIsAcceptedCondition(QueryBuilder $qb, ?bool $accepted = null): void
    {
        if ($accepted === false) {
            $qb->andWhere($qb->expr()->isNull('u.acceptedAt'));
        } elseif ($accepted === true) {
            $qb->andWhere($qb->expr()->isNotNull('u.acceptedAt'));
        }
    }
}
