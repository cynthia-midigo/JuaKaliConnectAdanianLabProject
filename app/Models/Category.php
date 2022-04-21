<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type'
    ];

    public function products()
    {
    	return $this->hasMany('app\Models\Product', 'id', 'category_id');
    }
}
