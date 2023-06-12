<?php
/**
 * Category service.
 */

namespace App\Service;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\BugRepository;

/**
 * Class CategoryService.
 */
class CategoryService implements CategoryServiceInterface
{
    /**
     * Category repository.
     */
    private CategoryRepository $categoryRepository;

    private BugRepository $bugRepository;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Constructor.
     *
     * @param CategoryRepository $categoryRepository category repository
     * @param BugRepository      $bugRepository      bug repository
     * @param PaginatorInterface $paginator          paginator
     */
    public function __construct(CategoryRepository $categoryRepository, BugRepository $bugRepository, PaginatorInterface $paginator)
    {
        $this->bugRepository = $bugRepository;
        $this->categoryRepository = $categoryRepository;
        $this->paginator = $paginator;
    }// end __construct()

    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->categoryRepository->queryAll(),
            $page,
            CategoryRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }// end getPaginatedList()

    /**
     * Save entity.
     *
     * @param Category $category Category entity
     */
    public function save(Category $category): void
    {
        if (null === $category->getId()) {
            $category->setCreatedAt(new \DateTimeImmutable());
        }

        $category->setUpdatedAt(new \DateTimeImmutable());

        $this->categoryRepository->save($category);
    }// end save()

    /**
     * Delete category.
     *
     * @param Category $category category
     */
    public function delete(Category $category): void
    {
        $this->categoryRepository->delete($category);
    }// end delete()

    /**
     * Can Category be deleted?
     *
     * @param Category $category Category entity
     *
     * @return bool Result
     */
    public function canBeDeleted(Category $category): bool
    {
        try {
            $result = $this->bugRepository->countByCategory($category);

            return !($result > 0);
        } catch (NoResultException|NonUniqueResultException) {
            return false;
        }
    }// end canBeDeleted()

    /**
     * Find by id.
     *
     * @param int $id Category id
     *
     * @return Category|null Category entity
     *
     * @throws NonUniqueResultException
     */
    public function findOneById(int $id): ?Category
    {
        return $this->categoryRepository->findOneById($id);
    }
}// end class
