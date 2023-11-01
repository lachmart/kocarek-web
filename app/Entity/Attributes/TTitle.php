<?php declare(strict_types = 1);

namespace App\Entity\Attributes;

use Doctrine\ORM\Mapping\Column;

trait TTitle
{

    #[Column(type: 'string')]
    protected string $title;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

}
