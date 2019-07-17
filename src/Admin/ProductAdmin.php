<?php
/**
 * Created by PhpStorm.
 * User: skillup_student
 * Date: 03.07.19
 * Time: 20:09
 */

namespace App\Admin;


use App\Entity\Catalogs;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\Form\Type\CollectionType;

class ProductAdmin extends AbstractAdmin
{
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('id')
            ->addIdentifier('name')
            ->addIdentifier('catalogs')
            ->addIdentifier('price')
            ->addIdentifier('description')
            ->addIdentifier('isTop')

        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('name')
            ->add('catalogs')
            ->add('price')
            ->add('description')
            ->add('isTop')
        ;
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form

            ->add('name')
            ->add('catalogs', ModelType::class, [
                'class' => Catalogs::class,
                'property' => 'name',
            ])
            ->add('images',
                CollectionType::class,
                [
                    'by_reference' => false
                ],
                [
                    'edit' => 'inline',
                    'inline'=> 'table',
                ])
            ->add('price')
            ->add('description')
            ->add('isTop')
        ;
    }
}