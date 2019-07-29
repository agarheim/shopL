<?php
/**
 * Created by PhpStorm.
 * User: skillup_student
 * Date: 29.07.19
 * Time: 19:53
 */

namespace App\Service;


use App\Entity\Order;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class OrderService
{ const SESSION_KEY;
    /**
     * @var EntityManagerInterface
     */
private  $entityManager;
    /**
     * @var Session
     */
private  $session;

    /**
     * OrderService constructor.
     * @param EntityManagerInterface $entityManager
     * @param Session $session
     */
    public function __construct(EntityManagerInterface $entityManager, Session $session,
OrderRepository $orderRepository)
    {
        $this->entityManager = $entityManager;
        $this->session = $session;
        $this->orderRepository;
    }
    public function getOrder()
    {$order=null;
    $orderId=$this->session->get(self::SESSION_KEY);
        if ($orderId)
        {
            $order=$this->orderRepository->find($orderId);
        }
        if(!$order)
        {
            $order= new Order();
        }
        return $order;
    }

}