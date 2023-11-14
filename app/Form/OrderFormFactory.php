<?php declare(strict_types=1);

namespace App\Form;

use App\Entity\Order;
use App\Presenters\ProductPresenter;
use App\Services\OrderService;
use App\Services\ProductService;
use Nette\Application\UI\Form;
use Nette\Mail\Mailer;
use Nette\Mail\Message;

class OrderFormFactory
{

    public function __construct(
        private readonly ProductService $productService,
        private readonly OrderService $orderService,
        private readonly Mailer $smtpMailer,
        Mailer                        $mailer,
    )
    {
    }

    public function create(): Form
    {
        $form = new Form();

        $products = $this->productService->qb()->andWhere('p.active = true')->andWhere('p.stock > 0')->getQuery()->getResult();
        $productsArray = [];
        foreach ($products as $product){
            $productsArray[$product->getId()] = $product->getTitle();
        }

        $form->addRadioList('color', 'Barva', $productsArray)->setRequired();
        $form->addRadioList('size', 'Velikost', [186 => '186 cm',190 => '190 cm',193 => '193 cm',196 => '196 cm', 200 => '200 cm', 203 => '203 cm', 206 => '206 cm', 'jine' => 'jiná'])->setRequired();
        $form->addText('name', 'Jméno')->setRequired('Prosím vyplň jméno, ať víme komu to poslat.');
        $form->addText('email', 'E-mail')->setRequired('Potřebujeme i e-mail, pro další kontakt.');
        $form->addText('phone', 'Telefon');
        $form->addText('packetery', 'Zásilkovna')->setRequired('I Zásilkovna je povinná, ať můžeme pásek poslat.');
        $form->addTextArea('note', 'Poznámka');

        $form->addSubmit('submit', 'Závazně objednat');

        $form->onSuccess[] = [$this, 'success'];
        $form->onError[] = [$this, 'error'];

        return $form;
    }

    public function error(Form $form): void
    {
        $presenter = $form->getPresenter();
        $presenter->flashMessage('Bohužel byl někdo rychlejší. Tato barva už je vyprodaná', 'danger');
        $presenter->redirect('this');
    }
    public function success(Form $form): void
    {
        $values = $form->getValues();
        /** @var ProductPresenter $presenter */
        $presenter = $form->getPresenter();

        $product = $this->productService->getRepository()->find($values->color);
        if(!$product || !$product->getStock()){
            $presenter->flashMessage('Bohužel byl někdo rychlejší. Tato barva už je vyprodaná', 'danger');
            $presenter->redirect('this');
        }else{
            $product->setStock($product->getStock()-1);
            $this->productService->persist($product);
        }

        $order = new Order();
        $order->setProduct($product);
        $order->setSize((string) $values->size);
        $order->setTitle($values->name);
        $order->setEmail($values->email);
        $order->setPhone($values->phone);
        $order->setPacketery($values->packetery);
        $order->setNote($values->note);
        $order->setCreatedAt(new \DateTime());
        $this->orderService->persist($order);

        $mail = new Message;
        $mail->setFrom('Sviticikocarek.cz <chci@sviticikocarek.cz>')
            ->addTo('lachmart@gmail.com')
            ->setSubject('Nová objednávka')
            ->setBody("Nová objednávka!.");
        $this->smtpMailer->send($mail);

        $presenter->flashMessage('Paráda, pásek ti blokujeme. E-mailem ti potvrdíme objednávku a pošleme platební údaje.', 'danger');
        $presenter->redirect('this');

    }

}
