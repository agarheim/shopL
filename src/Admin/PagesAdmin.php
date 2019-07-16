<?php


namespace App\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;


class PagesAdmin extends AbstractAdmin
{
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('id')
            ->addIdentifier('name')
            ->addIdentifier('content')
            ->addIdentifier('parent')

        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('id')
            ->add('name')
            ->add('content' )
            ->add('parent')

        ;
    }


    protected function configureFormFields(FormMapper $form)
    {
        $form

            ->add('name')
            ->add('content' )
            ->add('parent')
           ;
    }
}