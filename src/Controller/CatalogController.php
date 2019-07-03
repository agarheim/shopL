<?php

namespace App\Controller;

use App\Entity\Catalogs;
use App\Repository\CatalogsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CatalogController extends AbstractController
{
    /**
     * @Route("/catalog", name="catalog")
     */
    public function index(CatalogsRepository $repository)
    {
        $catalogs = $repository->findAll();
        return $this->render('catalog/index.html.twig', [
            'catalogs' => $catalogs,
        ]);
    }

    /**
     * @Route("/catalog/{id}", name="catalogs")
     */
    public function show(Catalogs $catalogs)
    {
       // $catalogs = $repository->find($id);
        return $this->render('catalog/show.html.twig', [
            'catalogs' => $catalogs,
        ]);
    }
}
