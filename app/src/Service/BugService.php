<?php
/**
 * Bug service.
 */

namespace App\Service;

use App\Entity\Bug;
use App\Entity\User;
use App\Entity\Status;
use App\Repository\BugRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class BugService.
 */
class BugService implements BugServiceInterface
{
    /**
     * Category service.
     */
    private CategoryServiceInterface $categoryService;

    /**
     * Bug repository.
     */
    private BugRepository $taskRepository;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Constructor.
     *
     * @param CategoryServiceInterface $categoryService Category service
     * @param PaginatorInterface       $paginator       Paginator
     * @param BugRepository           $taskRepository  Bug repository
     */
    public function __construct(
        CategoryServiceInterface $categoryService,
        PaginatorInterface       $paginator,
        BugRepository            $taskRepository,
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
    public function getPaginatedList(int $page, ?User $author, array $filters = []): PaginationInterface
    {
        $filters = $this->prepareFilters($filters);

        return $this->paginator->paginate(
            $this->taskRepository->queryAll($filters),
            $page,
            BugRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save entity.
     *
     * @param Bug $task Bug entity
     */
    public function save(Bug $task): void
    {
        $this->taskRepository->save($task);
    }

    /**
     * Delete entity.
     *
     * @param Bug $task Bug entity
     */
    public function delete(Bug $task): void
    {
        $this->taskRepository->delete($task);
    }

    /**
     * Find by id.
     *
     * @param int $status bug.status Status
     *
     * @return Status|null Bug entity
     *
     * @throws NonUniqueResultException
     */
    public function findOneByStatus(int $id): ?Bug
    {
        return $this->taskRepository->findOneById($id);
    }

}
