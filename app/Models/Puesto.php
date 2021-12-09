<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Puesto extends Model
{
    use HasFactory;
    
    use SoftDeletes;
    
    protected $table = 'puesto';
    
    public $timestamps = false;
    
    protected $fillable = ['nombre','salarioMinimo','salarioMaximo'];
    
    protected $attributes = ['salarioMinimo' => 965];
    
    public function empleados () {
        return $this->hasMany ('App\Models\Empleado', 'idpuesto');
    }
}
