<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];

    /**
     * The attributes that should be casted to
     * different data types.
     *
     * @var array
     */
    protected $casts = [
        'meals' => 'array',
        'extras' => 'array',
    ];

    /**
     * Default values for attributes
     * 
     * @var  array attribute as key and default as value
     */
    protected $attributes = [
        'meals' => '[0,0,0,0,0]',
        'extras' => '[0,0,0,0,0]',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [];

    /**
     * A student belongs to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\User::class)->withDefault();
    }

    /**
    * A student has many meal order items.
    */
    /*public function mealOrderItems()
    {
        return $this->hasMany(\App\MealOrderItem::class);
    }*/
}
