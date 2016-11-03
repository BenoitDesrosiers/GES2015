<?php
/**
 * Created by PhpStorm.
 * User: marcopolo
 * Date: 2016-11-02
 * Time: 7:41 PM
 */

namespace App\Models;


class DelegueTelephone extends EloquentValidating
{
    protected $guarded = array('id');

    public function delegue_telephone() {
        return $this->belongsTo(Delegue::class);
    }

    protected $fillable = [
        'telephone',
        'delegue_id'
    ];

    public function validationRules()
    {
        return [
            'telephone' => 'string'
        ];
    }
}