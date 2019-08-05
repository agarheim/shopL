<?php


namespace App\Controller;


use App\Entity\Pages;
use App\Repository\PagesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    /**
     * @Route("/pages/edit/{id}", name="editpages")
     */
    public function editPages(Pages $pages, $id, Request $request)
    {
        if($_POST) {
            $entityManager = $this->getDoctrine()->getManager();
            $page = $entityManager->getRepository(Pages::class)->find($id);

            if (!$page) {
                throw $this->createNotFoundException(
                    'No product found for id ' . $id
                );
            }
            $page->setName($request->request->get('title'));
            $page->setContent($request->request->get('content'));
            $entityManager->flush();
            return $this->redirectToRoute('default');
        }
        return $this->render('pages/edit.html.twig', [
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