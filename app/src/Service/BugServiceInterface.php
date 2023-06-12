<?php
/**
 * Bug service interface.
 */

namespace App\Service;

use App\Entity\Bug;
use App\Entity\User;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Interface BugServiceInterface.
 */
interface BugServiceInterface
{
    /**
     * Get paginated list.
     *
     * @param int   $page    Page number
     * @param User  $author  Bug author
     * @param array $filters Bug filter
     *
     * @return PaginationInterface<SlidingPagination> Paginated list
     */
    public function getPaginatedList(int $page, User $author, array $filters = []): PaginationInterface;

    /**
     * Save entity.
     *
     * @param Bug $bug Bug entity
     */
    public function save(Bug $bug): void;

    /**
     * Delete entity.
     *
     * @param Bug $bug Bug entity
     */
    public function delete(Bug $bug): void;
}
