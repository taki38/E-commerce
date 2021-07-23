<?php

namespace App\Controller;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountOrderController extends AbstractController
{
    private $entityManager;


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/account/order", name="account_order")
     */
    public function index(): Response
    {
        $user = $this->getUser();
        $orders = $this->entityManager->getRepository(Order::class)->findSuccessOrders($user);
        return $this->render('account/order.html.twig', [
            'title' => 'Mes commandes',
            'orders' => $orders
        ]);
    }

    /**
     * @Route("/compte/mes-commandes/{reference}", name="account_order_show")
     */
    public function show($reference)
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByReference($reference);
        if (!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('account_order');
        }

        return $this->render('account/order_show.html.twig', [
            'order' => $order,
            'title' => 'Ma commande'.' '.$order->getReference()
        ]);
    }
}
