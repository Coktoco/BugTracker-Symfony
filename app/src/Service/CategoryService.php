<?php
/**
 * Category service.
 */

namespace App\Service;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\TaskRepository;

/**
 * Class CategoryService.
 */
class CategoryService implements CategoryServiceInterface
{

    /**
     * Category repository.
     */
    private CategoryRepository $categoryRepository;

    private TaskRepository $taskRepository;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;


    /**
     * Constructor.
     *
     * @param CategoryRepository $categoryRepository Category repository.
     * @param PaginatorInterface $paginator          Paginator.
     * @param TaskRepository     $taskRepository     Task repository.
     */
    public function __construct(CategoryRepository $categoryRepository, TaskRepository $taskRepository,PaginatorInterface $paginator)
    {
        $this->taskRepository     = $taskRepository;
        $this->categoryRepository = $categoryRepository;
        $this->paginator          = $paginator;

    }//end __construct()


    /**
     * Get paginated list.
     *
     * @param integer $page Page number
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

    }//end getPaginatedList()


    /**
     * Save entity.
     *
     * @param Category $category Category entity
     */


    /**
     * Save entity.
     *
     * @param Category $category Category entity
     */
    public function save(Category $category): void
    {
        if (null == $category->getId()) {
            $category->setCreatedAt(new \DateTimeImmutable());
        }

        $category->setUpdatedAt(new \DateTimeImmutable());

        $this->categoryRepository->save($category);

    }//end save()


    /**
     * @param  Category $category
     * @return void
     */
    public function delete(Category $category): void
    {
        $this->categoryRepository->delete($category);

    }//end delete()


    /**
     * Can Category be deleted?
     *
     * @param Category $category Category entity
     *
     * @return boolean Result
     */
    public function canBeDeleted(Category $category): bool
    {
        try {
            $result = $this->taskRepository->countByCategory($category);

            return !($result > 0);
        } catch (NoResultException | NonUniqueResultException) {
            return false;
        }

    }//end canBeDeleted()

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


}//end class
