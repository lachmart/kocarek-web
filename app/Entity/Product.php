<?php declare(strict_types = 1);

namespace App\Entity;

use App\Entity\Attributes\TTitle;
use App\Entity\Attributes\TActive;
use App\Entity\Attributes\TId;
use App\Entity\Attributes\TSequence;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;

#[ORM\Entity]
#[ORM\Table()]
class Product
{
    use TId;
    use TTitle;
    use TActive;
    use TSequence;

    #[Column(type: 'integer', nullable: true, options: ['default' => null])]
    protected ?int $stock = null;

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(?int $stock): void
    {
        $this->stock = $stock;
    }

}
