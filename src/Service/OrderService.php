<?php


namespace App\Service;


use App\Entity\Order;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Tests\Functional\Bundle\TestBundle\Controller\SessionController;

class OrderService
{
    const SESSION_KEY='current_order';
    /**
     * @var EntityManagerInterface
     */
         private $entitymanager;
    /**
     * @var SessionController
     */
    private $sessions;
    /**
     * @var OrderRepository
     */
    private $orderRepo;


         public function __construct(EntityManagerInterface $entityManager,
                                     SessionController $sessions,
                                    OrderRepository $orderRepo)
         {
             $this->entitymanager=$entityManager;
             $this->sessions= $sessions;
             $this->orderRepo=$orderRepo;
         }

         public function getOrder():Order
         { $order=null;
            $orderId=$this->session->get(self::SESSION_KEY);
            if($orderId){
             $order=$this->orderRepo->find($orderId);
            }
            if(!$order){
                $order= new Order();
            }
            return $order;
         }
}