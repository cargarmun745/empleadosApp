<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empleado extends Model
{
    use HasFactory;
    
    use SoftDeletes;
    
    protected $table = 'empleado';
    
    public $timestamps = false;
    
    protected $fillable = ['nombre','apellidos','email','telefono','fechacontrato','idpuesto','iddepartamento'];
    
    public function puesto () {
        return $this->belongsTo ('App\Models\Puesto', 'idpuesto');
    }
    
    public function empleadoJefe (){
        return $this->belongsTo ('App\Models\Departamento', 'idempleadojefe');
    }
    
    public function departamento (){
        return $this->belongsTo ('App\Models\Departamento', 'iddepartamento');
    }
}
