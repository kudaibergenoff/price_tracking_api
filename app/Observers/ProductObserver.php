<?php

namespace App\Observers;

use App\Jobs\UserProductChangeNotice;
use App\Models\Product;

class ProductObserver
{
    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        dispatch(new UserProductChangeNotice($product));
    }
}
