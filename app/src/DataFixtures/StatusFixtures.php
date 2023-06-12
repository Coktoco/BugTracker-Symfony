<?php
/*
 * Status fixtures.
 */


namespace App\DataFixtures;

use App\Entity\Status;

/**
 *
 */
class StatusFixtures extends AbstractBaseFixtures
{
    /**
     * @return void
     */
    public function loadData(): void
    {
        $this->createMany(4, 'statuses', function ($i) {
            $status = new Status();
            $status->setStatus($this->faker->unique()->word);

            return $status;
        });

        $this->manager->flush();
    }
}
