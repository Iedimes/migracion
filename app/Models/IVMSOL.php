<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IVMSOL extends Model
{


    protected $table = 'IVMSOL';
    protected $connection = 'sqlsrv';
    protected $casts = [
        'SolFum'  => 'date:Y-m-d',
        //'joined_at' => 'datetime:Y-m-d H:00',
    ];


    protected $fillable = [
        'SolPerCod',
        'SolSer',
        'SolNro',
        'SolFch',
        'SolTieUni',
        'SolAuto',
        'SolEquipo',
        'SolMaquin',
        'SolAnimal',
        'SolOtros',
        'SolTipo',
        'SolInscri',
        'SolComent',
        'SolPerCge',
        'SolHabViv',
        'SolFum',
        'SolEtapa',
        'SolReFecAd',
        'SolReNroAd',
        'SolCodObra',
        'SolComent'


    ];


    //protected $fillable = ['NroExp','NroExpS','ExpDId'];
    //protected $primaryKey = ['NroExp', 'NroExpS', 'ExpDId'];
    public $incrementing = false;
    protected $primaryKey = 'SolPerCod';
    public $timestamps = false;
}
