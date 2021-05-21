<?php
namespace App\Http\Traits;
 use Carbon\Carbon;

 trait CalculatePriceTrait {
     public function calculatePrice($startDate, $dateTwo, $price): float
     {
         $dateOfIssue = Carbon::parse($startDate);
         $dateOfExpiry = Carbon::parse($dateTwo);
         $days = $dateOfExpiry->diffInDays($dateOfIssue);

         $newPrice = str_replace(',','', $price);
         $total = $days * (float) $newPrice;
         return round($total, 2);
     }
 }
