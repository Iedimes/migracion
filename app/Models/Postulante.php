<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Postulante extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'cedula',
        'marital_status',
        'nacionalidad',
        'gender',
        'birthdate',
        'localidad',
        'asentamiento',
        'ingreso',
        'address',
        'grupo',
        'phone',
        'mobile',
        'nexp',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/postulantes/'.$this->getKey());
    }
}
