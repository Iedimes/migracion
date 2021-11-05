<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostulanteHasDiscapacidad extends Model
{
    protected $table = 'postulante_has_discapacidad';

    protected $fillable = [
        'postulante_id',
        'discapacidad_id',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/postulante-has-discapacidads/'.$this->getKey());
    }
}
