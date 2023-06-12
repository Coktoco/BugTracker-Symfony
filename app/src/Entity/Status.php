<?php
/*
 * Status entity.
 */

namespace App\Entity;

use App\Repository\StatusRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class Status.
 */
#[ORM\Entity(repositoryClass: StatusRepository::class)]
#[ORM\Table(name: 'statuses')]
#[ORM\UniqueConstraint(name: 'uq_statuses_status', columns: ['status'])]
#[UniqueEntity(fields: ['status'])]
class Status
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 20)]
    private ?string $status = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string|null $status
     *
     * @return void
     */
    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }
}
