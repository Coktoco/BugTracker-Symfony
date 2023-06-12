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
     * Primary key.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * Status.
     */
    #[ORM\Column(length: 20)]
    private ?string $status = null;

    /**
     * Getter for Id.
     *
     * @return int|null ?int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for Status.
     *
     * @return string|null ?string
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Setter for Status.
     *
     * @param ?string $status status
     */
    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }
}
