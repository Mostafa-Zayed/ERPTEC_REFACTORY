<?php

namespace Modules\Cms\Entities;

use Illuminate\Database\Eloquent\Model;

class CustomerMessage extends Model
{
    protected $table = 'cusomter_messages';
    
    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = ['id'];
    
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     **/ 
}