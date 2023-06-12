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
     * Constructor.
     *
     * @param CategoryServiceInterface $categoryService Category service
     * @param PaginatorInterface       $paginator       Paginator
     * @param BugRepository            $bugRepository   Bug repository
     */
    public function __construct(CategoryServiceInterface $categoryService, PaginatorInterface $paginator, BugRepository $bugRepository)
    {
        $this->categoryService = $categoryService;
        $this->paginator = $paginator;
        $this->bugRepository = $bugRepository;
    }

    /**
     * Get paginated list.
     *
     * @param int                $page    Page number
     * @param User               $author  Bugs author
     * @param array<string, int> $filters Filters array
     *
     * @return PaginationInterface<SlidingPagination> Paginated list
     */
    public function getPaginatedList(int $page, ?User $author, array $filters = []): PaginationInterface
    {
        $filters = $this->prepareFilters($filters);

        return $this->paginator->paginate(
            $this->bugRepository->queryAll($filters),
            $page,
            BugRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save entity.
     *
     * @param Bug $bug Bug entity
     */
    public function save(Bug $bug): void
    {
        $this->bugRepository->save($bug);
    }

    /**
     * Delete entity.
     *
     * @param Bug $bug Bug entity
     */
    public function delete(Bug $bug): void
    {
        $this->bugRepository->delete($bug);
    }

    /**
     * Find by id.
     *
     * @param int $id Bug id
     *
     * @return Status|null Bug entity
     *
     * @throws NonUniqueResultException
     */
    public function findOneByStatus(int $id): ?Bug
    {
        return $this->bugRepository->findOneById($id);
    }

    /**
     * Category service.
     */
    private CategoryServiceInterface $categoryService;

    /**
     * Bug repository.
     */
    private BugRepository $bugRepository;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

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
            $bug = $this->findOneByStatus($filters['status_id']);
            if (null !== $bug) {
                $resultFilters['status'] = $bug;
            }
        }

        return $resultFilters;
    }
}
