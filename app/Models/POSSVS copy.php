<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class POSSVS extends Model
{
    protected $table = 'POSSVS';

    protected $connection = 'sqlsrv';

    public $timestamps = false;

    protected $primaryKey = 'PsvCod';

    public $incrementing = false;

    /*public function tiposol()
    {
        return $this->hasOne('App\Models\SIG0001', 'TexCod', 'TexCod');
    }*/

    //protected $primaryKey = 'SEOBId';

    /*public function distrito() {
        return $this->hasOne('App\Distrito','CiuId','CiuId');
    }

    public function departamento() {
        return $this->hasOne('App\Departamento','DptoId','DptoId');
    }*/
}
