<?php


namespace App\Controller;


use App\Entity\Pages;
use App\Repository\PagesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PagesController extends AbstractController
{
    /**
     * @Route("/pages/{id}", name="pages")
     */
    public function show(Pages $pages)
    {     return $this->render('pages/index.html.twig', [
            'pages' =>$pages,
        ]);
    }

    public function headerslist(PagesRepository $pagesRepository)
    {
        return $this->render("pages/_header_list.html.twig",
            ['pages'=>$pagesRepository->findAll(),
            ]);
    }
}