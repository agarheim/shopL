<?php
/**
 * Created by PhpStorm.
 * User: skillup_student
 * Date: 12.08.19
 * Time: 19:44
 */

namespace App\Twig;


use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
   public function getFilters()
   {
       return [ new  TwigFilter('money', [$this, 'formatMoney']),
           ];
   }

   public function formatMoney($value)
   {
       return twig_localized_currency_filter($value / 100, 'UAH');
   }
}