<?php
/**
 * Bug service interface.
 */

namespace App\Service;

use App\Entity\Bug;
use App\Entity\User;
use App\Entity\Status;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Interface BugServiceInterface.
 */
interface BugServiceInterface
{
    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<SlidingPagination> Paginated list
     */
    public function getPaginatedList(int $page, User $author, array $filters = []): PaginationInterface;

    /**
     * Save entity.
     *
     * @param Bug $task Bug entity
     */
    public function save(Bug $task): void;

    /**
     * Delete entity.
     *
     * @param Bug $task Bug entity
     */
    public function delete(Bug $task): void;
}