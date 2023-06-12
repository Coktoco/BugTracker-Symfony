<?php
/**
 * Bug repository.
 */

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Bug;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class BugRepository.
 *
 * @method Bug|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bug|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bug[]    findAll()
 * @method Bug[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @extends ServiceEntityRepository<Bug>
 */
class BugRepository extends ServiceEntityRepository
{
    /**
     * Items per page.
     *
     * Use constants to define configuration options that rarely change instead
     * of specifying them in configuration files.
     * See https://symfony.com/doc/current/best_practices.html#configuration
     *
     * @constant int
     */
    public const PAGINATOR_ITEMS_PER_PAGE = 10;

    /**
     * Constructor.
     *
     * @param ManagerRegistry $registry Manager registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bug::class);
    }

    /**
     * Query all records.
     *
     * @param array<string, object> $filters Filters
     *
     * @return QueryBuilder Query builder
     */
    public function queryAll(array $filters): QueryBuilder
    {
        $queryBuilder = $this->getOrCreateQueryBuilder()
            ->select(
                'partial bug.{id, createdAt, updatedAt, title, status, content}',
                'partial category.{id, title}',
                'partial status.{id, status}',
            )
            ->join('bug.status', 'status')
            ->join('bug.category', 'category')
            ->orderBy('bug.updatedAt', 'DESC');

        return $this->applyFiltersToList($queryBuilder, $filters);
    }

    /**
     * Count tasks by category.
     *
     * @param Category $category Category
     *
     * @return int Number of tasks in category
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function countByCategory(Category $category): int
    {
        $qb = $this->getOrCreateQueryBuilder();

        return $qb->select($qb->expr()->countDistinct('bug.id'))
            ->where('bug.category = :category')
            ->setParameter(':category', $category)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Query tasks by author.
     *
     * @param UserInterface         $user    User entity
     * @param array<string, object> $filters Filters
     *
     * @return QueryBuilder Query builder
     */
    public function queryByAuthor(UserInterface $user, array $filters = []): QueryBuilder
    {
        $queryBuilder = $this->queryAll($filters);

        $queryBuilder->andWhere('bug.author = :author')
            ->setParameter('author', $user);

        return $queryBuilder;
    }

    /**
     * @param StatusInterface $status
     * @param array           $filters
     *
     * @return QueryBuilder
     */
    public function queryByStatus(StatusInterface $status, array $filters = []): QueryBuilder
    {
        $queryBuilder = $this->queryAll($filters);

        $queryBuilder->andWhere('bug.status = :status')
            ->setParameter('status', $status);

        return $queryBuilder;
    }

    /**
     * Save entity.
     *
     * @param Bug $bug Bug entity
     */
    public function save(Bug $bug): void
    {
        $this->_em->persist($bug);
        $this->_em->flush();
    }

    /**
     * Delete entity.
     *
     * @param Bug $bug Bug entity
     */
    public function delete(Bug $bug): void
    {
        $this->_em->remove($bug);
        $this->_em->flush();
    }

    /**
     * Apply filters to paginated list.
     *
     * @param QueryBuilder          $queryBuilder Query builder
     * @param array<string, object> $filters      Filters array
     *
     * @return QueryBuilder Query builder
     */
    private function applyFiltersToList(QueryBuilder $queryBuilder, array $filters = []): QueryBuilder
    {
        if (isset($filters['category']) && $filters['category'] instanceof Category) {
            $queryBuilder->andWhere('category = :category')
                ->setParameter('category', $filters['category']);
        }

        if (isset($filters['status']) && $filters['status'] instanceof Status) {
            $queryBuilder->andWhere('status = :status')
                ->setParameter('status', $filters['status']);
        }

        return $queryBuilder;
    }

    /**
     * Get or create new query builder.
     *
     * @param QueryBuilder|null $queryBuilder Query builder
     *
     * @return QueryBuilder Query builder
     */
    private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
    {
        return $queryBuilder ?? $this->createQueryBuilder('bug');
    }
}
