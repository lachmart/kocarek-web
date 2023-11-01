<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Form\OrderFormFactory;
use App\Services\ProductService;
use Nette;
use Nette\DI\Attributes\Inject;
use Nette\Forms\Form;

final class ProductPresenter extends Nette\Application\UI\Presenter
{
    #[Inject]
    public ProductService $productService;
    #[Inject]
    public OrderFormFactory $orderFormFactory;

    function actionDefault(){
        $this->template->productWhite = $this->productService->getRepository()->find(1);
        $this->template->productBlack = $this->productService->getRepository()->find(2);
    }
    
    protected function createComponentOrderForm(): Form
    {
        return $this->orderFormFactory->create();
    }
}
