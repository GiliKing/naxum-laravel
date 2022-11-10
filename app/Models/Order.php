<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';


    // query search

    public function scopeFilter($query, array $filters){
        
        if($filters['order_date'] ?? false) {
            $query->where('order_date', 'like', '%' . request('order_date'). '%');
        };

        // if($filters['distributor'] ?? false) {

        //     $query->where('referred_by', 'like', '%' . request('distributor'). '%');

        // };


    }


}
