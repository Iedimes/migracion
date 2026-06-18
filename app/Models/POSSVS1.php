<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class POSSVS1 extends Model
{
    protected $table = 'POSSVS1';

    protected $connection = 'sqlsrv';

    public $timestamps = false;

    protected $primaryKey = 'PsvCod';

    public $incrementing = false;

    protected $fillable = [
        'PsvCod',
        'Psvord',
        'PsvBibNro',
        'PsvExpNro',
        'PsvExpS',
        'PsvTDPos',
        'PsvTDPosM',
        'PsvCedTit',
        'PsvNomTit',
        'PsvTDCge',
        'PsvTDCgeM',
        'PsvCedCge',
        'PsvNomCge',
        'PsvNivel',
        'PsvCanHij',
        'PsvDiscap',
        'PsvTerEdad',
        'PsvSosten',
        'PsvAporte',
        'PsvIfac',
        'PsvObs',
        'PsvDomi',
        'PsvRegCon',
        'PsvUsuIng',
        'PsvUsuMod',
        'PsvFecIng',
        'PsvFecMod',
        'PsvIngTit',
        'PsvIngCge',
        'PsvIngOtr',
        'PsvIngFam',
        'PsvNomSos',
        'PsvTitFNac',
        'PsvCgeFNac',
        'PsvTerreno',
        'PsvObsSost',
        'PsvObs2'


    ];

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
