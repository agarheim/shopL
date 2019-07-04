<?php


namespace App\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class CatalogsAdmin extends AbstractAdmin
{
    protected function configureListFields(ListMapper $list)
    {
     $list
         ->addIdentifier('id')
         ->addIdentifier('name')
         ->addIdentifier('description')
         ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
     $filter
         ->add('id')
         ->add('name')
         ->add('description')
         ;
    }

    protected function configureFormFields(FormMapper $form)
    {
     $form

         ->add('name')
         ->add('description')
         ;
    }


}