<?php declare(strict_types = 1);

namespace App\Entity;

use App\Entity\Attributes\TTitle;
use App\Entity\Attributes\TActive;
use App\Entity\Attributes\TId;
use App\Entity\Attributes\TSequence;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\ManyToOne;

#[ORM\Entity]
#[ORM\Table('orders')]
class Order
{
    use TId;
    use TTitle;
    use TActive;
    use TSequence;

    #[Column(type: 'string', nullable: true, options: ['default' => null])]
    protected ?string $email = null;
    #[Column(type: 'string', nullable: true, options: ['default' => null])]
    protected ?string $phone = null;
    #[Column(type: 'string', nullable: true, options: ['default' => null])]
    protected ?string $size = null;
    #[Column(type: 'text', nullable: true, options: ['default' => null])]
    protected ?string $note = null;
    #[Column(type: 'string', nullable: true, options: ['default' => null])]
    protected ?string $packetery = null;
    #[ManyToOne(targetEntity: Product::class)]
    protected ?Product $product = null;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    public function getPacketery(): ?string
    {
        return $this->packetery;
    }

    public function setPacketery(?string $packetery): void
    {
        $this->packetery = $packetery;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): void
    {
        $this->note = $note;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): void
    {
        $this->product = $product;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(?string $size): void
    {
        $this->size = $size;
    }

}
