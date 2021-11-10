<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IVMSOL2 extends Model
{


    protected $table = 'IVMSOL2';
    protected $connection = 'sqlsrv';


    protected $fillable = [
        'SolPerCod',
        'GfsCod',
        'GfsEdad',
        'ParCod',
        'GfsDis',
        'GfsImpSue',
        'GfsImpApo',
        'GfsUsuCod',
        'GfsFecAlta'
    ];


    //protected $fillable = ['NroExp','NroExpS','ExpDId'];
    //protected $primaryKey = ['NroExp', 'NroExpS', 'ExpDId'];
    public $incrementing = false;
    protected $primaryKey = 'SolPerCod';
    public $timestamps = false;
}
