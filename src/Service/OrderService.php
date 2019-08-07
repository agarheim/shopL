<?php

namespace App\Service;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use App\Entity\User;
use App\Repository\OrderRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;


class OrderService
{

    const SESSION_KEY = 'currentOrder';

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var SessionInterface
     */
    private $sessions;

    /**
     * @var OrderRepository
     */
    private $orderRepo;

    /**
     * @var MailerInterface
     */
    private $mailer;

    /**
     * @var ParameterBagInterface
     */
    private  $parametrs;

    public function __construct(
        EntityManagerInterface $entityManager,
        SessionInterface $sessions,
        OrderRepository $orderRepo,
        MailerInterface $mailer,
    ParameterBagInterface $parametrs
    ) {
        $this->entityManager = $entityManager;
        $this->sessions = $sessions;
        $this->orderRepo = $orderRepo;
        $this->mailer=$mailer;
        $this->parametrs=$parametrs;
    }

    public function getOrder(): Order
    {
        $order = null;
        $orderId = $this->sessions->get(self::SESSION_KEY);

        if ($orderId) {
            $order = $this->orderRepo->find($orderId);
        }

        if (!$order) {
            $order = new Order();
        }

        return $order;
    }

    public function add(Product $product, int $count, ?User $user): Order
    {
        $order = $this->getOrder();
        $existingItem = null;

        foreach ($order->getItems() as $item) {
            if ($item->getProduct() === $product) {
                $existingItem = $item;
                break;
            }
        }

        if ($existingItem) {
            $newCount = $existingItem->getCount() + $count;
            $existingItem->setCount($newCount);
        } else {
            $existingItem = new OrderItem();
            $existingItem->setProduct($product);
            $existingItem->setCount($count);
            $order->addItem($existingItem);
        }

        $this->save($order, $user);

        return $order;
    }

    public function save(Order $order, ?User $user = null)
    {    if($user){
        $order->setUser($user);
    }
        $this->entityManager->persist($order);
        $this->entityManager->flush();

        $this->sessions->set(self::SESSION_KEY, $order->getId());
    }

    public function deleteItem(OrderItem $item)
    {
        $order = $item->getCart();
        $order->removeItem($item);
        $this->entityManager->remove($item);
        $this->save($order);
    }
 public function makeOrder(Order $order)
 {
     $order->setOrderedAt(new \DateTime());
     $this->save($order);
     $this->sessions->remove(self::SESSION_KEY);
     $this->sendAdminOrderMesage($order);
 }
    private function sendAdminOrderMesage(Order $order)
    {
        $message = new TemplatedEmail();
        $message->to(new Address($this->parametrs->get('orderAdminEmail')));
        $message->from('noreply@shop.com');
        $message->subject('Yовый заказ на сайте');
        $message->htmlTemplate('order/emails/admin.html.twig');
        $message->context(['order' => $order]);
        $this->mailer->send($message);

    }

}
