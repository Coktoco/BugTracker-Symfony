<?php

namespace App\DataFixtures;

use App\Entity\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StatusFixtures extends AbstractBaseFixtures
{
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
