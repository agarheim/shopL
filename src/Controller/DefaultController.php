<?php
/**
 * Created by PhpStorm.
 * User: skillup_student
 * Date: 26.06.19
 * Time: 20:00
 */

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index()
    {$var='Привет привет';
     return $this->render('default/index.html.twig',
         [
             'mess'=>$var,
         ]);
     //можно и так ответ отправить
         //return new Response('Hello, World!');
    }

}