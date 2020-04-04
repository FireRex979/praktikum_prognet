<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Courier extends Model
{

	use SoftDeletes;

    protected $table = 'couriers';
    
    protected $fillable = [
    	'courier'
    ];

    protected $dates = ['deleted_at'];
}
