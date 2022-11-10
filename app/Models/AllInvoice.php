<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllInvoice extends Model
{
    use HasFactory;


    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'all_invoice';

    protected $fillable = [
        "invoice",
        "order_id",
        "product_id",
        "quantity",
        "sku",
        "name",
        "price"
    ];

}
