<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleado', function (Blueprint $table) {
            
            $table->id();
            $table->string('nombre', 200);
            $table->string('apellidos', 200);
            $table->string('email');
            $table->bigInteger('telefono')->unique();
            $table->date('fechacontrato')->useCurrent();
            
            $table->bigInteger('idpuesto')->unsigned()->nullable();
            $table->bigInteger('iddepartamento')->unsigned()->nullable();
            $table->softDeletes();
            
            $table->foreign('idpuesto')->references('id')->on('puesto');
            $table->foreign('iddepartamento')->references('id')->on('departamento');
        });
        // $sql = 'alter table departamento add foreign key (idempleadojefe) references empleado (id)';
        // DB::statement($sql);
        Schema::table('departamento', function(Blueprint $table) {
            $table->foreign('idempleadojefe')->references('id')->on('empleado');
        });
    }
        

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empleado');
    }
}
