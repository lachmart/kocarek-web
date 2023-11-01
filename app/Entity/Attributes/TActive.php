<?php declare(strict_types = 1);

namespace App\Entity\Attributes;

use Doctrine\ORM\Mapping\Column;

trait TActive
{

    #[Column(type: 'boolean', options: ['default' => 1])]
    protected bool $active = true;

    public function getActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

}
