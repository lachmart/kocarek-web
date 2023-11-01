<?php declare(strict_types = 1);

namespace App\Entity\Attributes;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

trait TId
{

    #[Column(type: 'integer', nullable: false)]
    #[Id]
    #[GeneratedValue]
    private ?int $id;

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * This is necessary for testing purposes.
     * DO NOT USE!
     *
     * @internal
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function __clone()
    {
        $this->id = null;
    }

}
