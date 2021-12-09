<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departamento extends Model
{
    use HasFactory;
    
    use SoftDeletes;
    
    protected $table = 'departamento';
    
    public $timestamps = false;
    
    protected $fillable = ['nombre','localizacion'];
    
    
    // public function empleado (){
    //     return $this->belongsTo ('App\Models\Departamento', 'idempleadojefe');
    // }
    
    public function empleados (){
        return $this->hasMany ('App\Models\Empleado', 'iddepartamento');
    }
}
