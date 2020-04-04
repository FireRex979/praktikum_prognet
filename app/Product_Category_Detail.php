<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_Category_Detail extends Model
{
	protected $table='product_category_details';

    protected $fillable = [
        'category_id', 'product_id',
    ];

    public function category(){
    	return $this->hasOne('App\Category','id','category_id');
    }

    public function product(){
    	return $this->hasOne('App\Product','id','product_id');
    }
}
