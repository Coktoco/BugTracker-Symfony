<?php
/**
 * Task service.
 */

namespace App\Service;

use App\Entity\Task;
use App\Entity\User;
use App\Entity\Status;
use App\Repository\TaskRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class TaskService.
 */
class TaskService implements TaskServiceInterface
{
    /**
     * Category service.
     */
    private CategoryServiceInterface $categoryService;

    /**
     * Task repository.
     */
    private TaskRepository $taskRepository;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Constructor.
     *
     * @param CategoryServiceInterface $categoryService Category service
     * @param PaginatorInterface       $paginator       Paginator
     * @param TaskRepository           $taskRepository  Task repository
     */
    public function __construct(
        CategoryServiceInterface $categoryService,
        PaginatorInterface $paginator,
        TaskRepository $taskRepository,
    ) {
        $this->categoryService = $categoryService;
        $this->paginator = $paginator;
        $this->taskRepository = $taskRepository;
    }

    /**
     * Prepare filters for the tasks list.
     *
     * @param array<string, int> $filters Raw filters from request
     *
     * @return array<string, object> Result array of filters
     */
    private function prepareFilters(array $filters): array
    {
        $resultFilters = [];
        if (!empty($filters['category_id'])) {
            $category = $this->categoryService->findOneById($filters['category_id']);
            if (null !== $category) {
                $resultFilters['category'] = $category;
            }
        }

        if (!empty($filters['status_id'])) {
            $task = $this->findOneByStatus($filters['status_id']);
            if (null !== $task) {
                $resultFilters['status'] = $task;
            }
        }

        return $resultFilters;
    }

    /**
     * Get paginated list.
     *
     * @param int                $page    Page number
     * @param User               $author  Tasks author
     * @param array<string, int> $filters Filters array
     *
     * @return PaginationInterface<SlidingPagination> Paginated list
     */
    public function getPaginatedList(int $page, User $author, array $filters = []): PaginationInterface
    {
        if ($author === null) {

        }
        $filters = $this->prepareFilters($filters);

        return $this->paginator->paginate(
            $this->taskRepository->queryAll($filters),
            $page,
            TaskRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save entity.
     *
     * @param Task $task Task entity
     */
    public function save(Task $task): void
    {
        $this->taskRepository->save($task);
    }

    /**
     * Delete entity.
     *
     * @param Task $task Task entity
     */
    public function delete(Task $task): void
    {
        $this->taskRepository->delete($task);
    }

    /**
     * Find by id.
     *
     * @param int $status task.status Status
     *
     * @return Status|null Task entity
     *
     * @throws NonUniqueResultException
     */
    public function findOneByStatus(int $id): ?Task
    {
        return $this->taskRepository->findOneById($id);
    }

}
