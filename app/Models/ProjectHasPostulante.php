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
    protected $with = ['postulante', 'otros'/*, 'members', 'conyuge'*/];
    protected $withCount = ['members', 'childrens'];

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

    public function childrens()
    {
        return $this->hasMany(PostulanteHasBeneficiary::class, 'postulante_id', 'postulante_id')->whereIn('parentesco_id', [3]);
    }

    public function conyuge()
    {
        return $this->hasone(PostulanteHasBeneficiary::class, 'postulante_id', 'postulante_id')->whereIn('parentesco_id', [1, 8]);
    }

    public function otros()
    {
        return $this->hasone(PostulanteHasBeneficiary::class, 'postulante_id', 'postulante_id')->whereNotIn('parentesco_id', [1, 8]);
    }

    public static function getNivel($id)
    {
        $postulante = Postulante::find($id);
        if (!$postulante) {
            return null;
        }

        $miembros = PostulanteHasBeneficiary::where('postulante_id', $id)->get();
        $total = Postulante::whereIn('id', $miembros->pluck('miembro_id'))->get();
        $ingreso = $total->sum('ingreso');
        $grupo = $ingreso + $postulante->ingreso;

        if ($grupo <= 2798309) return '4';
        if ($grupo <= 5316789) return '3';
        if ($grupo <= 18077086) return '2';
        if ($grupo <= 90385435) return '1';

        return null;
    }
}
