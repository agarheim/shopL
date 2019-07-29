<?php
/**
 * Created by PhpStorm.
 * User: skillup_student
 * Date: 29.07.19
 * Time: 20:35
 */

namespace App\Controller;


use App\Entity\Product;
use App\Service\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
     *
     * @Route("/add-to-cart/{id}", name="order_add_to_cart")
     */
  public function addToCart(Product $product, OrderService $orderService)
  {
      $orderService->add($product,1);
      return $this->redirectToRoute('default');
  }
  public function headerCart(OrderService $orderService)
  {
      $order= $orderService->getOrder();
      return $this->render('order/header_cart.html.twig',[
          'order'=> $order,]);
  }
}