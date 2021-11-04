<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'sat_id',
        'state_id',
        'city_id',
        'modalidad_id',
        'leader_name',
        'localidad',
        'land_id',
        'typology_id',
        'action',
        'expsocial',
        'exptecnico',

    ];


    protected $dates = [
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url'];
    protected $with = ['postulantes'];
    protected $withCount = ['postulantes'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/projects/' . $this->getKey());
    }

    public function postulantes()
    {
        return $this->hasMany(ProjectHasPostulante::class);
    }

    public function totalpostulantes()
    {
        return $this->hasMany(ProjectHasPostulante::class)->sum('id');
    }
}
