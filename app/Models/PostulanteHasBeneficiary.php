<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostulanteHasBeneficiary extends Model
{
    protected $fillable = [
        'postulante_id',
        'miembro_id',
        'parentesco_id',

    ];


    protected $dates = [
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url'];
    protected $with = ['miembros', 'parentesco'];
    protected $withCount = ['miembros'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/postulante-has-beneficiaries/' . $this->getKey());
    }

    public function miembros()
    {
        return $this->belongsTo(Postulante::class, 'miembro_id');
    }

    public function parentesco()
    {
        return $this->belongsTo(Parentesco::class, 'parentesco_id');
    }
}
