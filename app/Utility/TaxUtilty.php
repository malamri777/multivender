<?php

namespace App\Utility;

use App\Models\Category;
use App\Models\Tax;
use Cache;

class TaxUtilty
{
    /*when with trashed is true id will get even the deleted items*/
    public static function getDefaultTaxValue()
    {
        $defaultTax = Cache::rememberForever('default_tax', function () {
            Tax::where('is_default', true)
                ->where('status', true)
                ->first()->value;
        });

        return $defaultTax;
    }
}
