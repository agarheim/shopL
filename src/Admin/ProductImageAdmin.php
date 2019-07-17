<?php
/**
 * Created by PhpStorm.
 * User: skillup_student
 * Date: 17.07.19
 * Time: 19:41
 */

namespace App\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProductImageAdmin extends AbstractAdmin
{
protected function configureFormFields(FormMapper $form)
{
    $form->add('image', VichImageType::class,
        ['required'=>false]);
}
}