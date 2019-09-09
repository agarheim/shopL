<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Sonata\AdminBundle\Form\Type\Filter\ChoiceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="category")
     */
    public function index(CategoryRepository $categoryRepository)
    {
        return $this->render('category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/category/{id}", name="category_show")
     */
    public function show(Category $category, Request $request, ProductRepository $productRepository)
    {  $form = $this->getSearchForm($category);
        $form->handleRequest($request);
        $products = $productRepository->findByFilter($category, $form->getData());
        return $this->render('category/show.html.twig', [
            'category' => $products,
            'form' => $form->createView(),
        ]);
    }

    public function headerList(CategoryRepository $categoryRepository)
    {
        return $this->render('category/_header_list.html.twig', [
            'categories' => $categoryRepository->findBy(['parent' => null] ),
        ]);
    }

    private function getSearchForm(Category $category)
    {
        $formBuilder = $this->createFormBuilder();
        $formBuilder->setMethod('GET');

        foreach ($category->getAttributes() as $attribute) {
            $values = $attribute->getValuesList();
            $choices = array_combine($values, $values);

            $formBuilder->add('attr'.$attribute->getId(), ChoiceType::class, [
                'multiple' => true,
                'expanded' =>true,
                'choices' => $choices,
                'label' => $attribute->getName(),
            ]);
        }
        return $formBuilder->getForm();
    }
}
