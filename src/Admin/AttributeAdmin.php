<?php
/**
 * Created by PhpStorm.
 * User: skillup_student
 * Date: 21.08.19
 * Time: 19:44
 */

namespace App\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\Json;

class AttributeAdmin extends AbstractAdmin
{
   public function configureListFields(ListMapper $list)
   {
     $list

         ->addIdentifier('category')
         ->addIdentifier('name')
         ;
   }

   public function configureDatagridFilters(DatagridMapper $filter)
   {
      $filter
          ->add('id')
          ->add('category')
          ->add('name')
          ;
   }
   public function configureFormFields(FormMapper $form)
   {
         $form

             ->add('category')
             ->add('name', ChoiceType::class, [
                 'choice_attr' => [
                     'class' => 'id-cat',
                 ]
             ])
             ->add('valuesList', TextareaType::class)
             ;
         $form->get('valuesList')->addModelTransformer(new CallbackTransformer(
             function ($valuesArray) {
                 return  $valuesArray ? implode("\n", $valuesArray) : '';
             },
         function ($valuesString){
                 $values = explode("\n", $valuesString);
                 $values = array_map('trim', $values);
                 $values = array_filter($values);

                 return $values;
         }
         ));
   }
}