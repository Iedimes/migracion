<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parentesco extends Model
{
    protected $table = 'parentesco';

    protected $fillable = [
        'name',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/parentescos/'.$this->getKey());
    }
}
