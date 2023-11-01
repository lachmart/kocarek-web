<?php declare(strict_types = 1);

namespace App\Entity\Attributes;

use Doctrine\ORM\Mapping\Column;

trait TSequence
{

    #[Column(type: 'integer', nullable: true, options: ['default' => null])]
    protected ?int $sequence = null;

    public function getSequence(): ?int
    {
        return $this->sequence;
    }

    public function setSequence(?int $sequence): void
    {
        $this->sequence = $sequence;
    }

}
