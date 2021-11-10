<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectHasPostulante extends Model
{
    protected $fillable = [
        'project_id',
        'postulante_id',

    ];


    protected $dates = [
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url'];
    protected $with = ['postulante'/*, 'members', 'conyuge'*/];
    protected $withCount = ['members'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/project-has-postulantes/' . $this->getKey());
    }

    public function postulante()
    {
        return $this->belongsTo(Postulante::class);
    }

    public function members()
    {
        return $this->hasMany(PostulanteHasBeneficiary::class, 'postulante_id', 'postulante_id');
    }

    public function conyuge()
    {
        return $this->hasone(PostulanteHasBeneficiary::class, 'postulante_id', 'postulante_id')->whereIn('parentesco_id', [1, 8]);
    }
}
