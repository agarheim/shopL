<?php


namespace App\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserAdmin extends AbstractAdmin
{
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('id')
            ->addIdentifier('email')
            ->addIdentifier('roles')
            ->addIdentifier('firstname')
            ->addIdentifier('lastname')
            ->addIdentifier('address')

        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('id')
            ->add('email')
            ->add('roles')
            ->add('firstname')
            ->add('lastname')
            ->add('address')
        ;
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form

            ->add('email')
            ->add('firstname')
            ->add('lastname')
            ->add('address', TextareaType::class)
            ->add('roles')
//            ->add('roles',ChoiceType::class, array(
//                'choices' => [
//                    'Admin' => '["ROLE_ADMIN"]',
//                    'User' => '["ROLE_USER"]',
//                    'HoKnows'   => '["hoknows"]'
//
//                ]))
        ;
    }
}