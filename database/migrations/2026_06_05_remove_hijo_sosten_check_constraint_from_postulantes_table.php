<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class RemoveHijoSostenCheckConstraintFromPostulantesTable extends Migration
{
    public function up()
    {
        DB::statement('ALTER TABLE postulantes DROP CONSTRAINT IF EXISTS postulantes_hijo_sosten_check');
    }

    public function down()
    {
        // No se puede revertir porque no guardamos la definición original
    }
}
