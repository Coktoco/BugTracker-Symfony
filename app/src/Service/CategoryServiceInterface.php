<?php
/**
 * Category service interface.
 */

namespace App\Service;

use App\Entity\Category;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Interface TaskServiceInterface.
 */
interface CategoryServiceInterface
{


    /**
     * Get paginated list.
     *
     * @param integer $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface;


    /**
     * Save entity.
     *
     * @param Category $category Category entity
     */
    public function save(Category $category): void;


    /**
     * @param Category $category
     * @return void
     */
    public function delete(Category $category): void;

    /**
     * Can Category be deleted?
     *
     * @param Category $category Category entity
     *
     * @return bool Result
     */
    public function canBeDeleted(Category $category): bool;


}//end interface
