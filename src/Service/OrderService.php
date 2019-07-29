<?php
/**
 * Created by PhpStorm.
 * User: skillup_student
 * Date: 29.07.19
 * Time: 19:53
 */

namespace App\Service;


use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class OrderService
{
    const SESSION_KEY='currentOrder';

    /**
     * @var EntityManagerInterface
     */
      private  $entityManager;

    /**
     * @var SessionInterface
     */
      private  $session;

    public function __construct(EntityManagerInterface $entityManager,
                                SessionInterface $session,
                                OrderRepository $orderRepository)
    {
        $this->entityManager = $entityManager;
        $this->sessions = $session;
        $this->orderRepository=$orderRepository;
    }
    public function getOrder()
    {$order=null;
    $orderId=$this->sessions->get(self::SESSION_KEY);
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
    public function add(Product $product, int $count): Order
    {
        $order=$this->getOrder();
        $existeningItem=null;
        foreach ($order->getItems() as $item) {
            if($item->getProduct()===$product)
            {$existeningItem=$item;
            break;}
        }
        if($existeningItem)
        {
            $newCount=$existeningItem->getCount()+$count;
            $existeningItem->setCount($newCount);
        }else
        {
            $existeningItem=new OrderItem();
            $existeningItem->setProduct($product);
            $existeningItem->setCount($count);
            $order->addItem($existeningItem);
        }
        $this->save($order);
        return $order;
    }
    public function save(Order $order)
    {
        $this->entityManager->persist($order);
        $this->entityManager->flush();

        $this->sessions->set(self::SESSION_KEY, $order->getId());
    }

}