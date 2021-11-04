<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BAMPER extends Model
{


    protected $table = 'BAMPER';
    protected $connection = 'sqlsrv';
    protected $casts = [
        'PerNac'  => 'date:Y-m-d',
        //'joined_at' => 'datetime:Y-m-d H:00',
    ];

    protected $fillable = [
        'PerCod',
        'PerNom',
        'PerApePri',
        'PerNomPri',
        'PerApeSeg',
        'PerNomSeg',
        'PerTpDoc',
        'ProCod',
        'ActCod',
        'PerNac',
        'DptoId',
        'CiuId',
        'PerRelPar',
        'PerEstCiv',
        'PerUser',
        'PerSexo',
        'PerFchNac',
        'PerFUM',
        'PerDomic',
        'PerTel1',
        'PerTel2'


    ];


    //protected $fillable = ['NroExp','NroExpS','ExpDId'];
    //protected $primaryKey = ['NroExp', 'NroExpS', 'ExpDId'];
    public $incrementing = false;
    protected $primaryKey = 'PerCod';
    public $timestamps = false;
}
