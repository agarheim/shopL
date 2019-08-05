<?php


namespace App\Service;


use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class OrderService
{
    const SESSION_KEY='current_order';
    /**
     * @var EntityManagerInterface
     */
         private $entitymanager;
    /**
     * @var SessionInterface
     */
    private $sessions;
    /**
     * @var OrderRepository
     */
    private $orderRepo;


         public function __construct(EntityManagerInterface $entityManager,
                                     SessionInterface $sessions,
                                    OrderRepository $orderRepo)
         {
             $this->entitymanager=$entityManager;
             $this->sessions= $sessions;
             $this->orderRepo=$orderRepo;
         }

         public function getOrder():Order
         { $order=null;
            $orderId=$this->sessions->get(self::SESSION_KEY);
            if($orderId){
             $order=$this->orderRepo->find($orderId);
            }
            if(!$order){
                $order= new Order();
            }
            return $order;
         }

         public function add(Product $product, int $count): Order
         {
             $order= $this->getOrder();
             $existeningItem=null;
             foreach ($order->getItems() as $item){
               if($item->getProduct()===$product){
                   $existeningItem=$item;
                   break;
               }
             }
             if($existeningItem){
                 $newCount=$existeningItem->getCount()+$count;
                 $existeningItem->setCount($newCount);
             }else{
                 $existeningItem= new OrderItem();
                 $existeningItem->setProduct($product);
                 $existeningItem->setCount($count);
                 $order->addItem($existeningItem);
             }
             $this->save($order);
             return $order;
         }
         public function save(Order $order)
         {
             $this->entitymanager->persist($order);
             $this->entitymanager->flush($order);
             $this->sessions->set(self::SESSION_KEY, $order->getId());
         }
}