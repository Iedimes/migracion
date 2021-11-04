<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SIG005L1 extends Model
{


    protected $table = 'SIG005L1';
    protected $connection = 'sqlsrvsecond';
    //protected $dateFormat = 'Y-m-d H:i:s.v';

    public function getDateFormat()
    {
        return 'Y-d-m H:i:s.v';
    }
    //protected $fillable = ['NroExp','NroExpS','ExpDId'];
    //protected $primaryKey = ['NroExp', 'NroExpS', 'ExpDId'];
    //public $incrementing = false;
    //protected $primaryKey = 'CerNro';
    public $timestamps = false;


}
