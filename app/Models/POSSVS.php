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
}
