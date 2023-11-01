<?php declare(strict_types = 1);

namespace App\Services;

use App\Entity\EntityManager;
use App\Entity\Product;

class ProductService extends BaseService
{

    public string $class;

    public function __construct(EntityManager $em)
    {
        parent::__construct($em);

        $this->class = Product::class;
    }

}
