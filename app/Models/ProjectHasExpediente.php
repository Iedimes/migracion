<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectHasExpediente extends Model
{
    protected $fillable = [
        'project_id',
        'exp',

    ];


    protected $dates = [
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url'];
    protected $with = ['project'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/project-has-expedientes/' . $this->getKey());
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
