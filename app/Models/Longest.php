<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Longest extends Model
{
    use HasFactory;

        /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'rank';

    protected $fillable = [
        'distributor',
        'total_sales',
    ];


}
