<?php
/**
 * Bug fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Bug;
use App\Entity\User;
use App\Entity\Status;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * Class BugFixtures.
 */
class BugFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     *
     * @psalm-suppress PossiblyNullPropertyFetch
     * @psalm-suppress PossiblyNullReference
     * @psalm-suppress UnusedClosureParam
     */
    public function loadData(): void
    {
        if (null === $this->manager || null === $this->faker) {
            return;
        }

        $this->createMany(100, 'bugs', function (int $i) {
            $bug = new Bug();
            $bug->setTitle($this->faker->sentence);
            $bug->setCreatedAt(
                DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween('-100 days', '-1 days')
                )
            );
            $bug->setUpdatedAt(
                DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween('-100 days', '-1 days')
                )
            );
            /** @var Category $category */
            $category = $this->getRandomReference('categories');
            $bug->setCategory($category);

            /** @var Status $status */
            $status = $this->getRandomReference('statuses');
            $bug->setStatus($status);

            /** @var User $author */
            $author = $this->getRandomReference('admins');
            $bug->setAuthor($author);

            /** @var Content $content */
            $bug->setContent($this->faker->text);

            return $bug;
        });

        $this->manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return string[] of dependencies
     *
     * @psalm-return array{0: CategoryFixtures::class, 1: UserFixtures::class}
     */
    public function getDependencies(): array
    {
        return [CategoryFixtures::class, UserFixtures::class];
    }
}
